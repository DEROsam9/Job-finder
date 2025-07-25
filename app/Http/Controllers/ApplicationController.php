<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ApplicationController extends Controller
{
    /**
     * Display a paginated list of applications.
     */
   public function index(Request $request)
    {
        Log::info('📥 Received filters', $request->all());

        $limit = $request->get('limit', 20);
    Log::info('🔍 Incoming Filters', $request->all());

        $query = Application::with(['client', 'career', 'status', 'payments']);

        // ✅ Filter by name or email (searches client first/middle/surname/email)
        if ($search = $request->input('search')) {
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('middle_name', 'like', "%$search%")
                ->orWhere('surname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // ✅ Filter by passport or ID number
        if ($passportId = $request->input('passport_id')) {
            $query->whereHas('client', function ($q) use ($passportId) {
                $q->where('passport_number', 'like', "%$passportId%")
                ->orWhere('id_number', 'like', "%$passportId%");
            });
        }

        // ✅ Filter by date range
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // ✅ Filter by status
    if ($status = $request->input('status')) {
        $query->whereHas('status', function ($q) use ($status) {
            $q->where('name', $status);
        });
    }


        $applications = $query->orderBy('created_at', 'desc')->paginate($limit);

        return response()->json([
            'data' => $applications
        ]);
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
