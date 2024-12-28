<?php

namespace App\Http\Controllers\API\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Village;

class VillageController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'kode_kecamatan' => 'required|exists:districts,kode',
            'pagination' => 'nullable|integer|min:1',
        ]);

        $pagination = $request->pagination ?? 10;
        $villages = Village::where('kode_kecamatan', $request->kode_kecamatan)->simplePaginate($pagination);

        return new ResponseJsonResource($villages, 'Villages data');
    }
} 