<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackApplicationController extends Controller
{
    public function track(Request $request)
{
    $validated = $request->validate([
        'id_number' => 'required|string',
        'reference_number' => 'required|string',
    ]);

    \Log::info('Track request received', ['input' => $request->all()]);
    \Log::info('Validated input', $validated);

    $application = Application::with(['client', 'career', 'status'])
        ->where('application_code', $validated['reference_number'])
        ->whereHas('client', function ($query) use ($validated) {
            $query->where('id_number', $validated['id_number']);
        })
        ->first();

    if (!$application) {
        \Log::warning('No matching application found', $validated);
        return back()->with('error', 'No application found for the provided ID number and reference number.');
    }

    \Log::info('Application found', [
        'application_id' => $application->id,
        'status' => $application->status->name ?? null,
    ]);

    return view('components.pages.track-application', compact('application'));
}

}
