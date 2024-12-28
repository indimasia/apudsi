<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class StoreController extends Controller
{
    //

    function store(StoreRequest $request) {
        $store = Store::create($request->validated());

        return new ResponseJsonResource($store, 'Store created successfully');
    }

    
}
