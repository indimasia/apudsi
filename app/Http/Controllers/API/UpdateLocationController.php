<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateLocationRequest;
use Illuminate\Http\Request;

class UpdateLocationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateLocationRequest $request)
    {
        $user = $request->user();
        $user->update([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'last_online' => now(),
        ]);

        return response()->json([
            'message' => 'Location updated',
        ]);
    }
}
