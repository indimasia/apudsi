<?php

namespace App\Http\Controllers\API\halalstyle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PostProfileRequest;
use App\Http\Resources\ResponseJsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        return new ResponseJsonResource($request->user()->load(['province', 'city', 'roles']), 'User data retrieved successfully');
    }
    
    function postProfile(PostProfileRequest $request) {
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
        
        return new ResponseJsonResource(auth()->user()->load(['province', 'city', 'roles']), 'User data updated successfully');
    }
}
