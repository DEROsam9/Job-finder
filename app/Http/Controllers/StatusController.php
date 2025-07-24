<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;


class StatusController extends Controller
{

public function index()
{
    return response()->json(Status::all());
}

public function store(StoreStatusRequest $request)
{
    $status = Status::create($request->validated());
    return response()->json($status, 201);
}

public function show(Status $status)
{
    return response()->json($status);
}

public function update(UpdateStatusRequest $request, Status $status)
{
    $status->update($request->validated());
    return response()->json($status);
}

public function destroy(Status $status)
{
    $status->delete();
    return response()->json(['message' => 'Status deleted successfully']);
}

}
