<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB = 5120 KB
        ]);

        $user = auth()->user();

        // Check if user already uploaded 5 documents
        $documentCount = \App\Models\Document::where('user_id', $user->id)->count();

        if ($documentCount >= 5) {
            return response()->json([
                'message' => 'Upload limit reached. You can only upload up to 5 documents.'
            ], 403);
        }

        // Store the file
        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        // Save document info
        $document = \App\Models\Document::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'file_path' => $path,
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully',
            'data' => $document,
        ]);
    }

    public function index()
    {
        $user = auth()->user();

        $documents = \App\Models\Document::where('user_id', $user->id)->get();

        return response()->json([
            'documents' => $documents
        ]);
    }

}
