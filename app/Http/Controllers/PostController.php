<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function edit_post_status(boolean $post_status,string $id)
    {
        $post=Post::findorfail($id);
        $post_status=Post::findorfail($post_status);
        if ($post_status==0){
        return response()->json([
            'status' => 'success',
            'message' => 'Posted on the opening page',
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
