<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use Illuminate\Http\Request;
use App\Models\VisitSaudiArticle;

class VisitSaudiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $paginate = $request->input('paginate', 10);
        $responseData = new VisitSaudiArticle();
        $responseData = $responseData->with('slideshows');
        if(!empty($status)) {
            $responseData = $responseData->where('status', $status);
        }

        $responseData = $responseData->orderBy('id', 'desc');
        $responseData = $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Visit Saudi articles retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data =  VisitSaudiArticle::with('slideshows')->findOrFail($id);
        return new ResponseJsonResource($data, 'Visit Saudi article retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
