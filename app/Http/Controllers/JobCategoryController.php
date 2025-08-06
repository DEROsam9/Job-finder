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

    $query = $this->jobCategoryRepository->with(['status']);

    if($request->has('active_only') && $request->boolean('active_only')){
        $query->whereHas('status', function($q) {
            $q->where('name','Active');
        });
    }

    // Add all your existing filters
    $query->when($request->has('name') && !empty($request->get('name')), function ($query) use ($request) {
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
        });

    $jobCategories = $query->paginate($request->get('limit', 20));
    
    return response()->json($jobCategories, 200);
}



    /**
     * Create and store a new job category.
     */

     public function store(StoreJobCategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            
            $jobCategory = $this->jobCategoryRepository->create($data);

            return response()->json($jobCategory, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create job category',
                'message' => $e->getMessage()
            ], 500);
        }
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

            $data = $request->validated();
            $jobCategory->update($data);

            return response()->json($jobCategory, 200);
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
