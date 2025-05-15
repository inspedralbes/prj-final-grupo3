<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $userId = auth()->id();
        $commentId = $request->comment_id;

        $existing = \App\Models\CommentLike::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['liked' => false]); // s’ha tret el like
        } else {
            \App\Models\CommentLike::create([
                'comment_id' => $commentId,
                'user_id' => $userId,
            ]);
            return response()->json(['liked' => true]); // s’ha afegit el like
        }
    }

}

