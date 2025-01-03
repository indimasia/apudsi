<?php

namespace App\Http\Controllers\API;

use App\Models\ShareContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ResponseJsonResource;
use App\Http\Requests\StoreShareContentRequest;

class ShareContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Retrieve only share contents with status 'publish'
            $shareContents = ShareContent::where('status', 'publish')->get();
            return new ResponseJsonResource($shareContents, 'Published share contents retrieved successfully');
        } catch (\Exception $e) {
            return new ResponseJsonResource(null, 'Failed to retrieve share contents: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShareContentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('share-contents', 'public');
        }

        $data['user_id'] = auth()->id();

        $shareContent = ShareContent::create($data);

        return new ResponseJsonResource($shareContent, 'Share content created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreShareContentRequest $request, string $id)
    {
        $shareContent = ShareContent::find($id);

        if (!$shareContent) {
            return new ResponseJsonResource(null, 'Share content not found', 404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($shareContent->image) {
                Storage::disk('public')->delete($shareContent->image);
            }
            $data['image'] = $request->file('image')->store('share-contents', 'public');
        }

        $shareContent->update($data);

        return new ResponseJsonResource($shareContent, 'Share content updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shareContent = ShareContent::find($id);

        if (!$shareContent) {
            return new ResponseJsonResource(null, 'Share content not found', 404);
        }

        if ($shareContent->image) {
            Storage::disk('public')->delete($shareContent->image);
        }

        $shareContent->delete();

        return new ResponseJsonResource(null, 'Share content deleted successfully', 200);
    }

    function addCounter($contentId) {
        $shareContent = ShareContent::find($contentId);
        if($shareContent) {
            $shareContent->share_counter = $shareContent->share_counter + 1;
            $shareContent->save();
            return new ResponseJsonResource($shareContent, 'Share Content Counter Updated Successfully');
        } else {
            return response()->json(['message' => 'Share Content Not Found'], 404);
        }
    }

}
