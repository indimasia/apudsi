<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSosRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Sos;
use Illuminate\Http\Request;

class SosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responseData = Sos::with(['user.province', 'user.city'])->where("updated_at", ">", now()->subMinutes(5))->orderByDesc('updated_at')->limit(100)->get();

        return new ResponseJsonResource($responseData, 'SOS retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSosRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $sos = Sos::where("user_id", auth()->user()->id);
        if($sos->exists()) {
            $sos->update([
                'note' => $data['note'],
                'updated_at' => now()
            ]);
        } else {
            Sos::create($data);
        }
        auth()->user()->update([
            'lat' => $data['lat'], 
            'lng' => $data['lng'],
            'last_online' => now(),
        ]);

        return response()->json(['message' => 'SOS has been sent'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ResponseJsonResource(Sos::with(['user.province', 'user.city'])->findOrFail($id), 'Sos retrieved successfully');
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
