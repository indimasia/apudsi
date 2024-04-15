<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Biro;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => 'required|in:biro,user',
        ]);
        if($request->type == "biro") {
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'phone' => 'required|string|unique:users|doesnt_start_with:08',
                'biro_code' => 'required|unique:biros,code|min:3|max:10',
                'owner' => 'required|string|max:255',
                'marketing_phone' => 'required|string|doesnt_start_with:08',
                'logo' => 'required|file|mimes:jpg,jpeg,png|max:1024',
                'province_code' => 'required|exists:provinces,kode',
                'city_code' => 'required|exists:cities,kode',
                'average_person_per_year' => 'required|integer',
            ]);
        } else {
            // Individu
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'phone' => 'required|string|unique:users|doesnt_start_with:08',
                'gender' => 'required|in:M,F',
                'biro_code' => [
                    'required',
                    Rule::exists('biros', 'code')->where(function (Builder $query) {
                        return $query->where("is_active", true);
                    }),
                ],
                'province_code' => 'required|exists:provinces,kode',
                'city_code' => 'required|exists:cities,kode',
            ]);
        }

        try {
            DB::beginTransaction();
            $message = "";
            $biro_code = strtoupper($request->biro_code);
            if($request->type == "biro") {
                // Upload Logo
                $logo = $request->file('logo')->store('biros', 'public');
                $biro = Biro::create([
                    'name' => $request->name,
                    'code' => $biro_code,
                    'owner' => $request->owner,
                    'marketing_phone' => $request->marketing_phone,
                    'logo' => $logo,
                    'province_code' => $request->province_code,
                    'city_code' => $request->city_code,
                    'average_person_per_year' => $request->average_person_per_year,
                    'is_active' => false,
                ]);

                $message = "Biro berhasil dibuat dan sedang dalam proses peninjauan oleh admin.";
            } else {
                // Individu
                $request->validate([
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:8',
                    'phone' => 'required|string|unique:users',
                    'gender' => 'required|in:M,F',
                    'biro_code' => 'required|exists:biros,code',
                    'province_code' => 'required|exists:provinces,kode',
                    'city_code' => 'required|exists:cities,kode',
                ]);

                $biro = Biro::where('code', $biro_code)->first();

                $message = "User berhasil dibuat";
            }
            
            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'biro_id' => $biro->id,
                'province_code' => $request->province_code,
                'city_code' => $request->city_code,
                'email_verified_at' => now(),
                'gender' => $request->gender,
                'is_active' => $request->type == "biro" ? false : true,
            ]);

            $user->assignRole($request->type);

            DB::commit();
            return new ResponseJsonResource([
                'user' => User::with(['roles', 'biro'])->find($user->id),
                'biro' => $biro,
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
