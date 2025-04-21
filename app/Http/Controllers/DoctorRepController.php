<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorRepController extends Controller
{
    public function repAction(Request $request)
    {
        $request->validate([
            'rep_id' => 'required|exists:users,id',
            'action' => 'required|in:approve,cancel',
        ]);

        $doctor = auth()->user();

        if ($doctor->role !== 'doctor') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $status = $request->action === 'approve' ? 'approved' : 'cancelled';

        DB::table('rep_requests')->updateOrInsert(
            ['doctor_id' => $doctor->id, 'rep_id' => $request->rep_id],
            ['status' => $status, 'updated_at' => now()]
        );

        return response()->json([
            'message' => "Medical representative {$status} successfully."
        ]);
    }

    public function assignSlot(Request $request)
    {
        $request->validate([
            'rep_id' => 'required|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'slot' => 'required|string',
        ]);

        $doctor = auth()->user();

        if ($doctor->role !== 'doctor') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $existing = DB::table('rep_slot_assignments')
            ->where('doctor_id', $doctor->id)
            ->where('date', $request->date)
            ->where('slot', $request->slot)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'This slot is already assigned.'], 409);
        }

        DB::table('rep_slot_assignments')->insert([
            'doctor_id' => $doctor->id,
            'rep_id' => $request->rep_id,
            'date' => $request->date,
            'slot' => $request->slot,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Slot assigned successfully.']);
    }
    public function getSlotsByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $doctor = auth()->user();

        // Ensure only doctors can access this
        if ($doctor->role !== 'doctor') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $slots = DB::table('rep_slot_assignments')
            ->where('doctor_id', $doctor->id)
            ->where('date', $request->date)
            ->join('users as reps', 'rep_slot_assignments.rep_id', '=', 'reps.id')
            ->select(
                'rep_slot_assignments.id',
                'rep_slot_assignments.date',
                'rep_slot_assignments.slot',
                'reps.id as rep_id',
                'reps.name as rep_name',
                'reps.profile_image',
                'reps.email'
            )
            ->get();

        return response()->json([
            'date' => $request->date,
            'slots' => $slots
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path('uploads/profile_photos/' . $user->profile_photo))) {
                unlink(public_path('uploads/profile_photos/' . $user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_photos'), $filename);

            $user->profile_photo = $filename;
        }

        // Update name and designation
        $user->name = $request->name;
        $user->designation = $request->designation;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
            'profile_photo_url' => $user->profile_photo
                ? url('uploads/profile_photos/' . $user->profile_photo)
                : null
        ]);
    }


}
