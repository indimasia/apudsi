<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VillageController extends Controller
{
    public function __invoke()
    {
        $villages = DB::table('wilayah_villages_view')->get();
        
        return response()->json([
            'data' => $villages
        ]);
    }
} 