<?php

namespace App\Http\Controllers\API\Master;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class DistrictController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'kode_kota' => 'required|exists:cities,kode',
            'pagination' => 'nullable|integer|min:1',
        ]);

        $pagination = $request->pagination ?? 10;
        $districts = District::where('kode_kota', $request->kode_kota)
            ->simplePaginate($pagination);

        return new ResponseJsonResource($districts, 'Districts data');
    }
} 