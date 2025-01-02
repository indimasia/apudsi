<?php

namespace App\Http\Controllers\API;

use App\Models\Agent;
use App\Models\AgentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ResponseJsonResource;
use App\Http\Requests\Agent\StoreAgentReportRequest;
use App\Http\Requests\Agent\UpdateAgentReportRequest;

class AgentReportController extends Controller
{

    function index(Request $request, string $agentId) {

        $responseData = AgentReport::with(['agent', 'createdBy', 'province', 'city', 'district', 'village'])
        ->where('agent_id', $agentId)
        ->where('created_by', auth()->user()->id)
        ->simplePaginate($request->paginate ?? 10);

        return new ResponseJsonResource($responseData, 'Agent Reports retrieved successfully');
    }

    function store(StoreAgentReportRequest $request, string $agentId) {
        try {
            $imagePath = $request->file('image')->store('agent_report/' . date('Y/m/d'), 'public');

            $agentReport = AgentReport::create([
                'title'         => $request->title,
                'location'      => $request->location,
                'lng'           => $request->lng,
                'lat'           => $request->lat,
                'image'         => $imagePath,
                'description'   => $request->description,
                'province_code' => $request->province_code,
                'city_code'     => $request->city_code,
                'district_code' => $request->district_code,
                'village_code'  => $request->village_code,
                'agent_id'      => $agentId,
                'created_by'    => $request->user()->id,
            ]);
    
            return new ResponseJsonResource($agentReport, 'Agent Report created successfully');

        } catch (\Exception $e) {
            Log::error('Failed to create agent report', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to create agent report',
                'error'   => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    function show(string $agentId, string $reportId) {
        try {
            $agentReport = AgentReport::with(['agent', 'createdBy', 'province', 'city', 'district', 'village'])
            ->where('agent_id', $agentId)
            ->findOrFail($reportId);

            return new ResponseJsonResource($agentReport, 'Agent Report retrieved successfully');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Agent Report not found',
                'error'   => $e->getMessage(),
            ], $e->getCode() ?: 404);
        }
    }

    function update(UpdateAgentReportRequest $request, string $agentId, string $reportId) {
        try {
            $agentReport = AgentReport::where('created_by', $request->user()->id)
            ->where('agent_id', $agentId)
            ->findOrFail($reportId);

            if ($request->hasFile('image')) {
                // delete old image
                if (Storage::disk('public')->exists($agentReport->image)) {
                    Storage::disk('public')->delete($agentReport->image);
                }

                // store new image
                $imagePath = $request->file('image')->store('agent_report/' . date('Y/m/d'), 'public');
                $agentReport->update([
                    'image' => $imagePath,
                ]);
            }

            $agentReport->update($request->except('image'));

            return new ResponseJsonResource($agentReport, 'Agent Report updated successfully');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update agent report',
                'error'   => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    function destroy(string $agentId, string $reportId) {
        try {
            $agentReport = AgentReport::where('created_by', auth()->user()->id)
            ->where('agent_id', $agentId)
            ->findOrFail($reportId);

            if (Storage::disk('public')->exists($agentReport->image)) {
                Storage::disk('public')->delete($agentReport->image);
            }

            $agentReport->delete();

            return new ResponseJsonResource(null, 'Agent Report deleted successfully');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete agent report',
                'error'   => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
