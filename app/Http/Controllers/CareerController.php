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
        ->with('jobCategory')
        ->paginate($request->get('limit', 8));

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
        return response()->json(null, 204);
    }

    public function getCategories()
    {
        return JobCategory::select('id', 'name')->get();
    }

    public function getJobsByCategory($categoryId)
    {
        $jobs = Career::where('job_category_id', $categoryId)->get(['id', 'name']);
        return response()->json($jobs);
    }
}
