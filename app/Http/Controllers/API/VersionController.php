<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class VersionController extends Controller
{
    public function __invoke(Request $request, GeneralSettings $settings)
    {
        $clientVersion = $request->version;
        $latestVersion = $settings->mobile_version;
        $needUpdate    = false;
        $forceUpdate   = false;

        if($clientVersion < $latestVersion) {
            $needUpdate     = true;
            $clientVersion2 = preg_replace('/\.\d+$/', '', $clientVersion);
            $latestVersion2 = preg_replace('/\.\d+$/', '', $latestVersion);
            if($clientVersion2 < $latestVersion2) {
                $forceUpdate = true;
            }
        }

        return new ResponseJsonResource([
            'mobile_version' => $latestVersion,
            'need_update'    => $needUpdate,
            'force_update'   => $forceUpdate,
        ], 'Version information');
    }
} 