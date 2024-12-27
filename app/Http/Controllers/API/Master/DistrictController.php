<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'kode_kota' => 'required|exists:wilayah_cities_view,kode',
            'pagination' => 'nullable|integer|min:1',
        ]);

        $pagination = $request->pagination ?? 10;
        
        $districts = District::where('kode_kota', $request->kode_kota)
            ->paginate($pagination);
        
        return response()->json($districts);
    }
} 