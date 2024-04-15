<?php

namespace App\Http\Controllers\API\Auth\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auths\V2\RegistrationRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Biro;
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
                    'address' => $request->address,
                    'is_active' => false,
                ]);

                Notification::route('mail', explode(",", app(GeneralSettings::class)->notify_registration_email_list))
                    ->notify(new RegistrationNotificationManagement($biro));

                $message = "Biro berhasil dibuat dan sedang dalam proses peninjauan oleh admin.";
            } else {
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
                'gender' => $request->gender ?? null,
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
