<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $tripId = $request->query('tripId');

        $comments = Comment::with('user:id,name')
            ->where('trip_id', $tripId)
            ->latest()
            ->get();
    

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tripId' => 'required|exists:recommended_trips,id',
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);
        
        $comment = Comment::create([
            'trip_id' => $request->tripId,
            'user_id' => auth()->id(),
            'text' => $request->comment,
            'rating' => $request->rating ?? 5,
        ]);        

        return response()->json($comment->load('user'));
    }
}

