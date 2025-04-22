<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;


class JobController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'industry' => 'required|string',
            'job_title' => 'required|string',
            'city' => 'required|string',
        ]);

        $job = JobPost::create([
            'user_id' => Auth::id(),
            'industry' => $request->industry,
            'company_description' => $request->company_description,
            'job_title' => $request->job_title,
            'city' => $request->city,
            'area' => $request->area,
            'pin_code' => $request->pin_code,
            'street_address' => $request->street_address,
            'job_types' => $request->job_types,
            'schedules' => $request->schedules,
            'recruitment_timeline' => $request->recruitment_timeline,
            'people_required' => $request->people_required,
            'job_description' => $request->job_description,
        ]);

        return response()->json([
            'message' => 'Job posted successfully!',
            'data' => $job
        ], 201);
    }

    public function index()
    {
        $jobs = JobPost::latest()->get();
        return response()->json($jobs);
    }

}
