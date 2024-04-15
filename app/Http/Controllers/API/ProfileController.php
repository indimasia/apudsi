<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PostProfileRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Biro;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        return new ResponseJsonResource($request->user()->load(['biro', 'roles']), 'User data retrieved successfully');
    }
    
    function postProfile(PostProfileRequest $request) {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if(auth()->user()->hasRole("biro")) {
            $data['code'] = strtoupper($request->biro_code);
            if($request->hasFile('logo')) {
                $logo = $request->file('logo')->store('biros', 'public');
                $data['logo'] = $logo;
            }

            Biro::find(auth()->user()->biro_id)
                ->update($data);
        }

        if($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('users', 'public');
            $data['photo'] = $photo;
        }
        auth()->user()->update($data);
        
        return new ResponseJsonResource(auth()->user()->load(['biro', 'roles']), 'User data updated successfully');
    }
}
