<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Groups\GroupStoreRequest;
use App\Http\Requests\Groups\GroupUpdateRequest;
use App\Http\Resources\ResponseJsonResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = $request->input('paginate', 10);
        $search = $request->input('search', '');
        $myGroup = $request->input('my', false);
        $responseData = new Group();

        $responseData = $responseData->with(['createdBy']);

        if($myGroup) {
            $responseData = $responseData->where(function($q) {
                $q->where('created_by', auth()->user()->id)
                    ->orWhereHas('members', function($q) {
                        $q->where('user_id', auth()->user()->id);
                    });
            });
        } else {
            $responseData = $responseData->where('created_by', '!=', auth()->user()->id);
            $responseData = $responseData->whereDoesntHave('members', function($q) {
                $q->where('user_id', auth()->user()->id);
            });
        }

        if(!empty($search)) {
            $responseData = $responseData->where('name', 'like', "%$search%");
        }

        $responseData = $responseData->orderBy('last_activity', 'desc');
        $responseData =  $responseData->simplePaginate($paginate);

        // Modify responseData
        $responseData->getCollection()->transform(function($group) {
            $group->is_owner = $group->created_by == auth()->user()->id;
            return $group;
        });
        

        return new ResponseJsonResource($responseData, 'Group retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupStoreRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('groups', 'public');
        }
        Group::create($data);

        return response()->json(['message' => 'Group has been created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Group::findOrFail($id);
            return new ResponseJsonResource($data, 'Group retrieved successfully');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $group = Group::findOrFail($id);

            if($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('groups', 'public');
            }

            $group->update($data);

            return response()->json(['message' => 'Group has been updated'], 200);
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not updated'], $e->getCode() ?: 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $group = Group::findOrFail($id);

            if($group->created_by != auth()->user()->id) {
                return response()->json(['message' => 'You are not authorized to delete this group'], 403);
            }

            $group->delete();

            return response()->json(['message' => 'Group has been deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not deleted'], $e->getCode() ?: 400);
        }
    }

    /**
     * Join the specified resource.
     */
    public function join(string $id)
    {
        try {
            $group = Group::findOrFail($id);
            if($group->created_by == auth()->user()->id) {
                return response()->json(['message' => 'You are the creator of this group, you cannot join'], 403);
            }

            if($group->members()->where('user_id', auth()->user()->id)->exists()) {
                return response()->json(['message' => 'You have already joined the group'], 403);
            }

            $group->members()->attach(auth()->user()->id);

            return response()->json(['message' => 'You have joined the group'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }
    }

    /**
     * Leave the specified resource.
     */
    public function leave(string $id)
    {
        try {
            $group = Group::findOrFail($id);
            if($group->created_by == auth()->user()->id) {
                return response()->json(['message' => 'You are the creator of this group, you cannot leave'], 403);
            }
    
            if(!$group->members()->where('user_id', auth()->user()->id)->exists()) {
                return response()->json(['message' => 'You are not a member of this group'], 403);
            }
    
            $group->chats()->where('sent_by', auth()->user()->id)->delete();
            $group->members()->detach(auth()->user()->id);
    
            return response()->json(['message' => 'You have left the group'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }

    }

    public function members(string $groupId)
    {
        try {   
            $group = Group::findOrFail($groupId);
            $members = $group->members()->get();

            return new ResponseJsonResource($members, 'Group members retrieved successfully');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }
    }

    public function memberShow(string $groupId, string $userId)
    {
        try {
            $group = Group::findOrFail($groupId);
            $member = $group->members()->findOrFail($userId);

            return new ResponseJsonResource($member, 'Group member retrieved successfully');
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }
    }

    public function removeUser(string $groupId, string $userId)
    {
        try {
            $group = Group::findOrFail($groupId);
            if($group->created_by != auth()->user()->id) {
                return response()->json(['message' => 'You are not authorized to remove user from this group'], 403);
            }
    
            if($group->created_by == $userId) {
                return response()->json(['message' => 'You cannot remove the creator of this group'], 403);
            }
    
            if(!$group->members()->where('user_id', $userId)->exists()) {
                return response()->json(['message' => 'User is not a member of this group'], 403);
            }
    
            $group->chats()->where('sent_by', $userId)->delete();
            $group->members()->detach($userId);
    
            return response()->json(['message' => 'User has been removed from the group'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Group not found'], $e->getCode() ?: 404);
        }
        
    }
}
