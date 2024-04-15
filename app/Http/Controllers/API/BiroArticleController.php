<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BiroArticles\StoreBiroArticleRequest;
use App\Http\Requests\BiroArticles\UpdateBiroArticleRequest;
use App\Http\Resources\ResponseJsonResource;
use Illuminate\Http\Request;
use App\Models\BiroArticle;

class BiroArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $paginate = $request->input('paginate', 10);
        $responseData = new BiroArticle();
        if(!empty($status)) {
            $responseData = $responseData->where('status', $status);
        }
        $responseData = $responseData->orderBy('id', 'desc');
        $responseData =  $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Biro articles retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBiroArticleRequest $request)
    {
        $data = $request->validated();
        $data['thumbnail'] = $request->file('thumbnail')->store('article-biro', 'public');
        BiroArticle::create($data);

        return response()->json(['message' => 'Article has been created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ResponseJsonResource(BiroArticle::findOrFail($id), 'Biro article retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBiroArticleRequest $request, string $id)
    {
        $article = BiroArticle::findOrFail($id);
        $data = $request->validated();
        if($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('article-biro', 'public');
        }
        $article->update($data);

        return response()->json(['message' => 'Article has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = BiroArticle::findOrFail($id);
        $article->delete();

        return response()->json(['message' => 'Article has been deleted'], 200);
    }
}
