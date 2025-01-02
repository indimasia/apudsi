<?php

namespace App\Http\Controllers\API\Auth;

use Exception;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\ResponseJsonResource;

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

            if ($request->user_type == 'seller') {
                $user->assignRole(['seller','user']);

                if ($request->has('shop')) {

                    $logo = null;
                    if ($request->hasFile('shop.logo')) {
                        // store logo
                        $logo = $request->file('shop.logo')->store('logo' , 'public');
                    }
                        
                        // create shop
                    $shop = Shop::create([
                        'name'        => $request->shop['name'],
                        'type'        => $request->shop['type'],
                        'description' => $request->shop['description'] ?? null,
                        'address'     => $request->shop['address'],
                        'logo'        => $logo,
                        'user_id'     => $user->id,
                    ]);
                }

            } else {
                $user->assignRole('user');
            }

            return ResponseJsonResource::make([
                'user' => User::with(['roles', 'province', 'city', 'district', 'village'])->find($user->id),
                'shop' => $shop ?? null,
            ], "User berhasil dibuat");

        } catch (Exception $e) {
            return response()->json([
                'message' => "Gagal membuat user",
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
