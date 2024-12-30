<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PostProfileRequest;
use App\Http\Resources\ResponseJsonResource;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return new ResponseJsonResource($request->user()->load(['province', 'city', 'district', 'village', 'roles', 'shops']), 'User data retrieved successfully');
    }

    function update(PostProfileRequest $request) {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('users', 'public');
            $data['photo'] = $photo;
        }
        auth()->user()->update($data);
        
        return new ResponseJsonResource(auth()->user()->load(['province', 'city', 'district', 'village', 'roles', 'shops']), 'User data updated successfully');
    }
}
