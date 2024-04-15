<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Emergency;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'published');
        $paginate = $request->input('paginate', 10);
        $responseData = new Emergency();
        if(!empty($status)) {
            $responseData = $responseData->where('status', $status);
        }

        $responseData = $responseData->orderBy('id', 'desc');
        $responseData =  $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Emergencies retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Emergency::findOrFail($id);
        return new ResponseJsonResource($data, 'Emergency retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
