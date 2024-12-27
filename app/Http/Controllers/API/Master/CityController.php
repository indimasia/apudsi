<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'kode_provinsi' => 'required|exists:provinces,kode'
        ]);

        $pagination = $request->pagination ?? 10;
        $cities = City::where('kode_provinsi', $request->kode_provinsi)->simplePaginate($pagination);

        return new ResponseJsonResource($cities, 'Cities data');
    }
}
