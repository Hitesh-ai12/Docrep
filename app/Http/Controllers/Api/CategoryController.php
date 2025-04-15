<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'doctor'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check if category with same name already exists
        if (Category::where('name', $request->name)->exists()) {
            return response()->json([
                'message' => 'Category name already exists.',
            ], 409); // 409 = Conflict
        }

        $category = Category::create([
            'name' => $request->name,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }


    public function index(Request $request)
    {
        $user = Auth::user();

        $categories = $user->role === 'admin' || $user->role === 'doctor'
            ? Category::where('user_id', $user->id)->get()
            : [];

        return response()->json([
            'logged_in_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'categories' => $categories,
        ]);
    }

    // Cate Update api
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'doctor'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = Category::where('id', $id)->where('user_id', $user->id)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category,
        ]);
    }
    // cat delete api
    public function destroy($id)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'doctor'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = Category::where('id', $id)->where('user_id', $user->id)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}

