<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class LoginController extends Controller
{
    public function __invoke(Request $request) {
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $credentials = [
            'password' => $request->password,
        ];

        if (preg_match('/^\d{16}$/', $request->nik)) {
            $credentials['nik'] = $request->nik;
        } else {
            $credentials['phone'] = $request->nik;
        }

        if (!auth()->attempt($credentials,true)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

    
        $user = auth()->user();
        // $user->update(['last_online' => now()]);
    
        $token         = $user->createToken('mobile')->plainTextToken;
        $data['user']  = $user->load(['roles', 'province', 'city', 'district', 'village']);
        $data['token'] = $token;
    
        return new ResponseJsonResource($data, 'Login success');
    }

}
