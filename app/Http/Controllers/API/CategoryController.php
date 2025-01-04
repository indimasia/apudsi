<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return new ResponseJsonResource($categories, 'Category retrieved successfully');
    }
}
