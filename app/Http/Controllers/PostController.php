<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// app/Http/Controllers/PostController.php
class PostController extends Controller
{
    public function index($id) {
        
        try {

            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }
            $posts = $blog->posts;
        
            return response()->json([
                'status' => 'success',
                'message' => 'Blog Posts retrieved successfully',
                'data' => $posts
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public function store(Request $request, $blog_id) {
        
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|url',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error["message"] = $errors[0];
            $error['status'] = 'ERROR';
            $error['code'] = 'VALIDATION_ERROR';
            return response()->json(["error" => $error], 400);
        } 

        try {
            $blog = Blog::find($blog_id);
            if(!$blog)
            {
                $error["message"] = "Blog not found";
                $error['status'] = 'error';
                return response()->json(["error" => $error], 404);
            }

            $post = $blog->posts()->create($payload);
            return response()->json([
                'status' => 'success',
                'message' => 'Blog Posts created successfully',
                'data' => $post
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        
    }

    public function show($blog_id, $post_id) {
        
        try {
            $blog = Blog::find($blog_id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found',
                    'data' => []
                ], 404);
            }
            $post = Post::find($post_id);
            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found',
                    'data' => []
                ], 404);
            }
            
            $posts = $post->load(['comments', 'likes']);
            return response()->json([
                'status' => 'success',
                'message' => 'Blog Post retrieved successfully',
                'data' => $posts
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update(Request $request, $blog_id, $post_id) {
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|url',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error["message"] = $errors[0];
            $error['status'] = 'ERROR';
            $error['code'] = 'VALIDATION_ERROR';
            return response()->json(["error" => $error], 400);
        } 

        try {
            $blog = Blog::find($blog_id);
            if(!$blog)
            {
                $error["message"] = "Blog not found";
                $error['status'] = 'error';
                return response()->json(["error" => $error], 404);
            }
            $post = Blog::find($post_id);
            if(!$post)
            {
                $error["message"] = "Post not found";
                $error['status'] = 'error';
                return response()->json(["error" => $error], 404);
            }

            $posts = $post->update($payload);
            return response()->json([
                'status' => 'success',
                'message' => 'Blog Posts updated successfully',
                'data' => $posts 
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy($blog_id,$post_id) {

        try {
            $blog = Blog::find($blog_id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }
            $post = Blog::find($post_id);
            if (!$post) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }

            if($post->delete())
            {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog Post deleted successfully',
                    'data' => $post
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete post',
                'data' => $blog
            ], 400);
        }
        catch(\Throwable $exp)
        {

        }
        return response()->json(null, 204);
    }
}

