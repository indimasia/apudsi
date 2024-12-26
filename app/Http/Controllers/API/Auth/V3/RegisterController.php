<?php

namespace App\Http\Controllers\API\Auth\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auths\V3\RegisterRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {
        try {

            $user = User::create([
                'name'              => $request->name,
                'password'          => bcrypt($request->password),
                'phone'             => $request->phone,
                'province_code'     => $request->province_code,
                'city_code'         => $request->city_code,
                'district_code'     => $request->district_code,
                'village_code'      => $request->village_code,
                'email'             => $request->email,
                'email_verified_at' => now(),
                'gender'            => $request->gender ?? null,
            ]);

            $user->assignRole('user');

            return ResponseJsonResource::make([
                'user' => User::with(['roles', 'province', 'city'])->find($user->id)
            ], "User berhasil dibuat");

        } catch (Exception $e) {
            return response()->json([
                'message' => "Gagal membuat user",
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
