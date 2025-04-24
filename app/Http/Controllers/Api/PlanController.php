<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        return response()->json([
            'status' => true,
            'message' => 'Plans fetched successfully.',
            'data' => $plans
        ]);
    }
    public function getPlanById($id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found.'
            ], 404);
        }

        return response()->json([
            'plan' => $plan
        ]);
    }
}
