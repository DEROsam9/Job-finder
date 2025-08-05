<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ApplicationController extends Controller
{

    private ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository){
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * Display a paginated list of applications.
     * @throws \Exception
     */
   public function index(Request $request): \Illuminate\Http\JsonResponse
   {

        $applications = $this->applicationRepository
            ->with(['client', 'career', 'status', 'payments'])
            ->when($request->has('name') && !empty($request->get('name')), function ($query) use ($request) {
                $search = $request->get('name');
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone_number', 'like', "%$search%");
                });
            })
            ->when($request->has('passport_or_id') && !empty($request->get('passport_or_id')), function ($query) use ($request) {
                $passportId = $request->get('passport_or_id');
                $query->whereHas('client', function ($q) use ($passportId) {
                    $q->where('passport_number', 'like', "%$passportId%")
                        ->orWhere('id_number', 'like', "%$passportId%");
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
            'data' => $applications
        ], 200);
    }


    /**
     * Store a newly created application.
     */
    public function store(StoreApplicationRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $application = $this->applicationRepository->create($validated);

        return response()->json([
            'message' => 'Application created successfully.',
            'data' => $application
        ], 201);
    }

    /**
     * Display the specified application.
     */
    public function show($id)
{
    $application = $this->applicationRepository->with(['client', 'career', 'status', 'payments'])->find($id);

    if (!$application) {
        return response()->json([
            'message' => 'Application not found.'
        ], 404);
    }

    return response()->json([
        'data' => $application
    ], 200);
}


    /**
     * Update the specified application.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
{
    $validated = $request->validated();

    if (empty($validated)) {
        return response()->json([
            'message' => 'No data provided.'
        ], 422);
    }

    $application->update($validated);

    return response()->json([
        'message' => 'Application updated successfully.',
        'data' => $application
    ], 200);
}


    /**
     * Remove the specified application.
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully.'
        ], 200);
    }
}
