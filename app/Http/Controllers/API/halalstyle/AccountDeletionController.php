<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Biro;
use App\Models\User;
use Illuminate\Http\Request;

class AccountDeletionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        if($user->hasRole("biro")) {
            User::where('biro_id', $user->biro_id)->delete();
            Biro::find($user->biro_id)->delete();
        } else {
            $user->delete();
        }

        return response()->json(['message' => 'Account deleted successfully']);
    }
}
