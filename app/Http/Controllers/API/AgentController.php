<?php

namespace App\Http\Controllers\API;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class AgentController extends Controller
{
    function index(Request $request) {
        $paginate = $request->input('paginate', 10);
        $responseData = Agent::orderBy('id', 'desc');
        $responseData = $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Agents retrieved successfully');
    }

    function show(string $id) {
        try {
            return new ResponseJsonResource(Agent::findOrFail($id), 'Agent retrieved successfully');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agent not found'], $e->getCode() ?: 404);
        }
    }

}
