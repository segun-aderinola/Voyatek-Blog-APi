<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// app/Http/Controllers/CommentController.php
class CommentController extends Controller
{
    public function store(Request $request, $post_id) {
        // $validated = $request->validate([
        //     'comment' => 'required|string',
        // ]);

        // $comment = $post->comments()->create([
        //     'user_id' => $request->user()->id,
        //     'comment' => $validated['comment'],
        // ]);

        // return response()->json($comment, 201);

        $payload = $request->all();

        $validator = Validator::make($payload, [
            'user_id' => 'required|string',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error["message"] = $errors[0];
            $error['status'] = 'ERROR';
            $error['code'] = 'VALIDATION_ERROR';
            return response()->json(["error" => $error], 400);
        }
        try {
            
            $post  = Post::find($post_id);
            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }
            
            $comment = Comment::insert([
                'post_id' => $post_id,
                'user_id' => $request->user_id,
                'content' => $request->comment,
            ]);
            if($comment)
            {
                return response()->json([
                    "status" => 'success', 
                    'message' => 'Post commented successfully', 
                    'data'=> $comment
                ],200);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

