<?php

namespace App\Http\Controllers\API\Auth\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auths\V2\RegistrationRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\User;
use App\Notifications\RegistrationNotificationManagement;
use App\Settings\GeneralSettings;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();
            $message = "";
            
            $message = "User berhasil dibuat";
            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'province_code' => $request->province_code,
                'city_code' => $request->city_code,
                'email_verified_at' => now(),
                'gender' => $request->gender ?? null,
                'spph' => $request->spph ?? null,
                'is_active' => $request->type == "biro" ? false : true,
            ]);

            $user->assignRole("user");

            DB::commit();
            return new ResponseJsonResource([
                'user' => User::with(['roles', 'province', 'city'])->find($user->id),
            ], $message);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => "Gagal membuat user",
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
