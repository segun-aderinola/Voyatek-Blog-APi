<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// app/Http/Controllers/LikeController.php
class LikeController extends Controller
{
    public function store(Request $request, $post_id) {
    
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'user_id' => 'required|string'
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
            $like = $post->likes()->create([
                'user_id' => $request->user_id,
            ]);
            if($like)
            {
                return response()->json(["status" => 'success', 'message' => 'Post liked successfully', 'data'=> $like], 200);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

