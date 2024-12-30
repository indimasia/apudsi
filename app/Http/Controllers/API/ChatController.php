<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Chat;
use App\Models\Group;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $groupId)
    {
        $paginate = $request->input('paginate', 10);
        $responseData = Chat::where("group_id", $groupId);
        $responseData = $responseData->with('member', 'sentBy');

        $responseData = $responseData->orderBy('id', 'desc');
        $responseData =  $responseData->simplePaginate($paginate)->transform(function($chat) {
            return array_merge($chat->toArray(), [
                'sent_at' => $chat->created_at->diffForHumans(),
                'sent_by_me' => $chat->sent_by == auth()->user()->id,
                'is_admin' => $chat->member->is_admin,
            ]);
        });

        return new ResponseJsonResource($responseData, 'Chat retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $groupId)
    {
        $data = $request->validate([
            'message' => 'required',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        try {
            $group = Group::findOrFail($groupId);
            if(!$group->members()->where('user_id', auth()->user()->id)->exists()) {
                return response()->json(['message' => 'You are not a member of this group'], 403);
            }
    
            if($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment')->store('chats', 'public');
            }
    
            $data['group_id'] = $groupId;
            $data['sent_by'] = auth()->user()->id;
            Chat::create($data);
    
            return response()->json(['message' => 'Chat has been sent'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Chat not sent'], $e->getCode() ?: 400);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $groupId, string $id)
    {
        $data = $request->validate([
            'message' => 'required',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $group = Group::findOrFail($groupId);
    
            if(!$group->members()->where('user_id', auth()->user()->id)->exists()) {
                return response()->json(['message' => 'You are not a member of this group'], 403);
            }
    
            $chat = Chat::findOrFail($id);
    
            if($chat->sent_by != auth()->user()->id) {
                return response()->json(['message' => 'You are not authorized to update this chat'], 403);
            }
    
            if($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment')->store('chats', 'public');
            } else {
                unset($data['attachment']);
            }
    
            $chat->update($data);
    
            return response()->json(['message' => 'Chat has been updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Chat not updated'], $e->getCode() ?: 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $groupId, string $id)
    {
        try {
            $group = Group::findOrFail($groupId);
    
            if(!$group->members()->where('user_id', auth()->user()->id)->exists()) {
                return response()->json(['message' => 'You are not a member of this group'], 403);
            }
    
            $chat = Chat::findOrFail($id);
    
            if($chat->sent_by != auth()->user()->id) {
                return response()->json(['message' => 'You are not authorized to delete this chat'], 403);
            }
    
            $chat->delete();
    
            return response()->json(['message' => 'Chat has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Chat not deleted'], $e->getCode() ?: 400);
        }
    }
}
