<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packages\StorePackageRequest;
use App\Http\Requests\Packages\UpdatePackageRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $paginate = $request->input('paginate', 10);
        $responseData = new Package();
        if(!empty($status)) {
            $responseData = $responseData->where('status', $status);
        }

        $responseData = $responseData->orderBy('id', 'desc');
        $responseData =  $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Package retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();
        $data['thumbnail'] = $request->file('thumbnail')->store('packages', 'public');
        Package::create($data);

        return response()->json(['message' => 'Package has been created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Package::with('slideshows')->findOrFail($id);
        return new ResponseJsonResource($data, 'Package retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, string $id)
    {
        $article = Package::findOrFail($id);
        $data = $request->validated();
        if($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('package', 'public');
        }
        $article->update($data);

        return response()->json(['message' => 'Package has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Package::findOrFail($id);
        $article->delete();

        return response()->json(['message' => 'Package has been deleted'], 200);
    }
}
