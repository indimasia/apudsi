<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pagination = $request->pagination ?? 10;
        $provinces = Province::simplePaginate($pagination);

        return new ResponseJsonResource($provinces, 'Provinces data');
    }
}
