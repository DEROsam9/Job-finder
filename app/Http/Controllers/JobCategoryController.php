<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;
use App\Models\Career;
use App\Models\Status;
use App\Repositories\JobCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Repositories\BaseRepository;


class JobCategoryController extends Controller
{
    private JobCategoryRepository $jobCategoryRepository;

    public function __construct(
        JobCategoryRepository $jobCategoryRepo
    )
    {
        $this->jobCategoryRepository = $jobCategoryRepo;
    }
    /**
     * List all job categories.
     */

    public function index(Request $request): JsonResponse
    {
        $jobCategories = $this->jobCategoryRepository
            ->where('status_id', Status::where('code','ACTIVE')->first()->id)
            ->paginate($request->get('limit', 10));

        return response()->json($jobCategories, 200);
    }


    /**
     * Create and store a new job category.
     */

    public function store(StoreJobCategoryRequest $request): JsonResponse
    {
        $slug = \Illuminate\Support\Str::slug($request->name);

        $jobCategory = $this->jobCategoryRepository->create([
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
            $jobCategory = $this->jobCategoryRepository->find($id);

            if (!$jobCategory) {
                return response()->json(['error' => 'Job category not found'], 404);
            }

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
            $jobCategory = $this->jobCategoryRepository->find($id);

            if (!$jobCategory) {
                return response()->json(['error' => 'Job category not found'], 404);
            }

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
            $jobCategory = $this->jobCategoryRepository->find($id);

            if (!$jobCategory) {
                return response()->json(['error' => 'Job category not found'], 404);
            }

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
