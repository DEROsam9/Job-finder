<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateClientDocumentRequest;
    use App\Models\Client;

class ClientDocumentController extends Controller
{
    public function index()
    {
        $documents = ClientDocument::with('client')->latest()->get();

        return response()->json([
            'data' => $documents
        ]);
    }

    public function show(ClientDocument $clientDocument)
    {
        return response()->json([
            'data' => $clientDocument->load('client')
        ]);
    }

    public function update(UpdateClientDocumentRequest $request, ClientDocument $clientDocument)
    {
        $validated = $request->validated();

        // If a new file is uploaded, store and update URL
        if ($request->hasFile('document_url')) {
            $file = $request->file('document_url');

            // Store on default disk or use 'obs' if Huawei OBS
            $path = $file->store('client-documents', 'public');
            $validated['document_url'] = Storage::url($path);

            // Optionally delete old file
            // Storage::delete(parse_url($clientDocument->document_url, PHP_URL_PATH));
        }

        $clientDocument->update($validated);

        return response()->json([
            'message' => 'Client document updated successfully.',
            'data' => $clientDocument
        ]);
    }

    public function destroy(ClientDocument $clientDocument)
    {
        $clientDocument->delete();

        return response()->json([
            'message' => 'Client document deleted.'
        ]);
    }


public function getByClient(Client $client)
{
    $documents = ClientDocument::where('client_id', $client->id)
        ->with('client')
        ->get();

    return response()->json([
        'data' => $documents
    ]);
}

public function approve(ClientDocument $clientDocument)
{
    $clientDocument->status = 'Verified';
    $clientDocument->save();

    return response()->json([
        'message' => 'Document approved successfully.',
        'data' => $clientDocument
    ]);
}

public function reject(Request $request, ClientDocument $clientDocument)
{
    $request->validate([
    'remarks' => 'required|string|max:255'
]);

    $clientDocument->status = 'Rejected';
    $clientDocument->remarks = $request->input('remarks', ''); // optional reason
    $clientDocument->save();

    return response()->json([
        'message' => 'Document rejected successfully.',
        'data' => $clientDocument
    ]);
}



}
