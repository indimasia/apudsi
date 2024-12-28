<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        return new ResponseJsonResource($request->user()->load(['province', 'city', 'district', 'village', 'roles', 'shops']), 'User data retrieved successfully');
    }
}
