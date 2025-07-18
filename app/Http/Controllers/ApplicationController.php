<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a paginated list of applications.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 20);

        $applications = Application::with(['client', 'career', 'status', 'payments']) // eager load if needed
            ->paginate($limit);

        return response()->json([
            'data' => $applications
        ], 200);
    }

    /**
     * Store a newly created application.
     */
    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        $application = Application::create($validated);

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
    $application = Application::with(['client', 'career', 'status', 'payments'])->find($id);

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
