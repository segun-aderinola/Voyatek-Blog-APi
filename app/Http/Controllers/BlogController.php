<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

// app/Http/Controllers/BlogController.php
class BlogController extends Controller
{
    public function index() {
       
        $blogs = Blog::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Blogs retrieved successfully',
            'data' => $blogs
        ]);
    }

    public function store(Request $request) {
        
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error["message"] = $errors[0];
            $error['status'] = 'ERROR';
            $error['code'] = 'VALIDATION_ERROR';
            return response()->json(["error" => $error], 400);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog post saved successfully',
            'data' => $blog
        ]);
    }

    public function show($id) {

        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }
            $blog->load('posts');
            return response()->json([
                'status' => 'success',
                'message' => 'Blog retrieved successfully',
                'data' => $blog
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
       
    }
    

    public function update(Request $request, $id) {
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error["message"] = $errors[0];
            $error['status'] = 'ERROR';
            $error['code'] = 'VALIDATION_ERROR';
            return response()->json(["error" => $error], 400);
        }

        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }
        
            if($blog->update($payload))
            {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog updated successfully',
                    'data' => $blog
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to update blog',
                'data' => $blog
            ], 400);
        } catch (\Throwable $th) {
            //throw $th;
        }

        
    }

    public function destroy($id) {
        
        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Blog not found'
                ], 404);
            }

            if($blog->delete())
            {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog deleted successfully',
                    'data' => $blog
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete blog',
                'data' => $blog
            ], 400);
        }
        catch(\Throwable $exp)
        {

        }
        
    }
}

