<?php

namespace App\Http\Controllers\API;

use App\Exports\BiroUserExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseJsonResource;
use App\Models\BiroUser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiroUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = $request->input('paginate', 10);
        $gender = $request->gender;
        $province_code = $request->province_code;
        $city_code = $request->city_code;

        $responseData = (new BiroUser())->with(['province', 'city']);

        if(!empty($gender))
            $responseData = $responseData->where("gender", $gender);
        if(!empty($province_code))
            $responseData = $responseData->where("province_code", $province_code);
        if(!empty($city_code))
            $responseData = $responseData->where("city_code", $city_code);

        $responseData = $responseData->orderBy('id', 'desc');
        $responseData =  $responseData->simplePaginate($paginate);

        return new ResponseJsonResource($responseData, 'Biro Users retrieved successfully');
    }

    public function download(Request $request) {
        $gender = $request->gender;
        $province_code = $request->province_code;
        $city_code = $request->city_code;
        
        return Excel::download(new BiroUserExport($gender, $province_code, $city_code), 'biro_users_'.time().'.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BiroUser::findOrFail($id);
        return new ResponseJsonResource($data, 'Biro User retrieved successfully');
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
