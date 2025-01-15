<?php

namespace App\Http\Controllers\API\Auth\V2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
     
            $status = Password::sendResetLink(
                $request->only('email')
            );
    
            if($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => __($status)
                ]);
            } else {
                return response()->json([
                    'message' => __($status)
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::info( 'err:' . $th->getMessage());
            //throw $th;
        }
    }
}
