<?php

namespace App\Http\Controllers\API\Auth\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'phone' => 'required|doesnt_start_with:08',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('phone', 'password');
        $credentials['is_active'] = true;
        if (!auth()->attempt($credentials,true)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = auth()->user();
        if($user->tokens()->count() > 0 && $request->force_login == false) {
            return response()->json([
                'need_force_login' => true,
                'message' => 'Akun sedang login di perangkat lain. Apakah Anda ingin keluar dari perangkat tersebut?'
            ], 409);
        }

        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;
        $data['user'] = $user->load(['biro', 'roles']);
        $data['token'] = $token;

        return new ResponseJsonResource($data, 'Login success');
    }
}
