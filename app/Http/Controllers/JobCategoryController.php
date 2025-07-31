<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;
use App\Models\Career;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Repositories\BaseRepository;


class JobCategoryController extends Controller
{

    private BaseRepository $baseRepository;

    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepository = $baseRepo;
    }
    /**
     * List all job categories.
     */
    // public function index(): JsonResponse
    // {
    //     $jobCategories = JobCategory::all();
    //     return response()->json($jobCategories, 200);
    // }
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('limit', 10);
        $page = $request->get('page', 1);

        $jobCategories = JobCategory::where('status', 'available')
                                ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($jobCategories, 200);
    }


    /**
     * Create and store a new job category.
     */
    // public function store(StoreJobCategoryRequest $request): JsonResponse
    // {
    //     try {
    //         $jobCategory = JobCategory::create($request->validated());
    //         return response()->json($jobCategory, 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to create job category',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function store(StoreJobCategoryRequest $request)
    {
        $slug = \Illuminate\Support\Str::slug($request->name);

        $jobCategory = JobCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return response()->json($jobCategory, 201);
    }


    /**
     * Display a specific job category by ID.
     */
    public function show($id): JsonResponse
    {
        try {
            $jobCategory = JobCategory::findOrFail($id);
            return response()->json($jobCategory, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Job category not found'], 404);
        }
    }

    /**
     * Update an existing job category.
     */
    public function update(UpdateJobCategoryRequest $request, $id): JsonResponse
    {
        try {
            $jobCategory = JobCategory::findOrFail($id);
            $jobCategory->update($request->validated());
            return response()->json($jobCategory, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Job category not found'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update job category',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a job category by ID.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $jobCategory = JobCategory::findOrFail($id);
            $jobCategory->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Job category not found'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete job category',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job titles (careers) under a specific job category.
     */
    public function getTitlesByCategory($categoryId): JsonResponse
    {
        $titles = Career::where('job_category_id', $categoryId)
                        ->orderBy('name', 'asc')
                        ->get(['id', 'name']);

        return response()->json($titles, 200);
    }
}
