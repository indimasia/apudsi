<?php

namespace App\Http\Controllers\API;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreShopRequest;
use App\Http\Resources\ResponseJsonResource;

class ShopController extends Controller
{
    function store(StoreShopRequest $request) {
        $shop = Shop::create($request->validated());

        return new ResponseJsonResource($shop, 'Shop created successfully');
    }
} 