<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\JobCategory;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\CareerRepository;

class CareerController extends Controller
{
    private CareerRepository $careerRepository;

    public function __construct(CareerRepository $careerRepo)
    {
        $this->careerRepository = $careerRepo;
    }

    public function index(Request $request)
    {
         $careers = $this->careerRepository
            ->with(['jobCategory','status'])
            ->when($request->has('name') && !empty($request->get('name')), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('name') . '%');
            })
            ->when($request->has('JobCategory') && !empty($request->get('JobCategory')), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('JobCategory') . '%');
            })
            ->when($request->has('JobTitle') && !empty($request->get('JobTitle')), function ($query) use ($request) {
                $query->whereHas('jobs', function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->get('JobTitle') . '%');
                });
            })
            ->when($request->has('from') && !empty($request->get('from')) && $request->has('to') && !empty($request->get('to')), function ($query) use ($request) {
                $query->whereBetween('created_at',[$request->get('from'), $request->get('to')]);
            })
            ->when($request->has('status_id') && !empty($request->get('status_id')), function ($query) use ($request) {
                $query->where('status_id', $request->get('status_id'));
            })
            ->paginate($request->get('limit', 20));

        return response()->json([
                'data' => $careers,
            ], 200);
    
    }
    /**
     * Display a listing of the resource.
     */
    public function _index(): JsonResponse
    {
        $careers = Career::all();
        return response()->json($careers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return data needed for creating a career, e.g., job categories and statuses
        $categories = JobCategory::select('id', 'name')->get();
        $statuses = Status::select('id', 'name')->get();
        return response()->json([
            'categories' => $categories,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:careers,slug'],
            'description' => ['nullable', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'slots' => ['required', 'integer', 'min:0'],
            'status_id' => ['required', 'exists:statuses,id'],
            'is_featured' => ['sometimes', 'boolean']
        ]);

        $career = Career::create($validated);
        return response()->json($career, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career): JsonResponse
    {
        return response()->json($career);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
        // Return data needed for editing a career, including the career data, categories, and statuses
        $categories = JobCategory::select('id', 'name')->get();
        $statuses = Status::select('id', 'name')->get();
        return response()->json([
            'career' => $career,
            'categories' => $categories,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:careers,slug,' . $career->id],
            'description' => ['nullable', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'slots' => ['required', 'integer', 'min:0'],
            'status_id' => ['sometimes', 'exists:statuses,id'], // Add this line

        ]);

        $career->update($validated);
        return response()->json($career);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career): JsonResponse
    {
        $career->delete();

        return response()->json([
            'message' => 'Deleted successfully',
        ], 204);
    }

    public function getCategories()
    {
        return JobCategory::select('id', 'name')->get();
    }

   public function getJobsByCategory($categoryId, Request $request)
{
    try {
        $careers = $this->careerRepository
            ->with(['jobCategory', 'status'])
            ->where('job_category_id', $categoryId)
            ->when($request->has('active_only') && $request->boolean('active_only'), function ($query) {
                $query->whereHas('status', function($q) {
                    $q->where('name', 'Active');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($careers, 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch careers',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
