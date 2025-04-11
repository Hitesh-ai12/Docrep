<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
            'credits' => 'required|integer',
            'features' => 'required',
        ]);

        Plan::create($request->all());

        return redirect()->back()->with('success', 'Plan created successfully.');
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->all());

        return redirect()->back()->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->back()->with('success', 'Plan deleted successfully.');
    }
}
