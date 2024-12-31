<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show() {
        $data = [
            'revenue'          => 5780000, 
            'total_orders'     => 178,     
            'new_orders'       => 39,      
            'orders_in_process'=> 23,      
            'completed_orders' => 41,      
            'failed_orders'    => 12,     
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data retrieved successfully',
            'data'    => $data,
        ]);
    }
}
