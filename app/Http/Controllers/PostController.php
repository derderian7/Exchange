<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::all();
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,100',
            'location' => 'required|string|max:100',
            'description' => 'string|max:100',
           // 'image' => //later/////
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->location
        ]
        );
        
        return response()->json([
            'status' => 'success',
            'message' => 'Post added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_post_status(string $id)
    {
        $post=Post::findorfail($id);
        $post_status=$post->post_status;
        if ($post_status==0){
            $post->update(['post_status'=>'1']);
            
            return response()->json([
            'status' => 'success',
            'message' => 'Posted on the ended page',
            ]);
        }
        else  {
            return response()->json([
              'status' => 'success',
               'message' => 'Posted on the ending page',
             ]);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|between:2,100',
            'location' => 'string|max:100',
            'description' => 'string|max:100',
           // 'image' => //later//
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $post=Post::findorfail($id);
        $post->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->location
        ]);
         return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
        ]);
       
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Post::destroy($id);
        Post::findorfail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ]);
    }
}
