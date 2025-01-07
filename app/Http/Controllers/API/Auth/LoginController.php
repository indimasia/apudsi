<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ResponseJsonResource;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required'],
            'password' => ['required'],
        ]);

            if (Auth::attempt(['nik' => $credentials['nik'], 'password' => $credentials['password']]) || Auth::attempt(['phone' => $credentials['nik'], 'password' => $credentials['password']])) {
                $user = auth()->user();
            
                $token         = $user->createToken('mobile')->plainTextToken;
                $data['user']  = $user->load(['roles', 'province', 'city', 'district', 'village']);
                $data['token'] = $token;
            
                return new ResponseJsonResource($data, 'Login success');
            }
            return new ResponseJsonResource(null, 'The provided credentials do not match our records.', 401);
    }
}
