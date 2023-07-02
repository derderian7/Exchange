<?php

namespace App\Http\Controllers;

use App\Models\Post;
use DB;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Illuminate\Database\QueryException;

class PostController extends Controller
{
    /**
     * Display all posts with their users . 
     */
    public function index()
    {
        try{
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as user_name', 'users.image as user_image','users.email as user_email')
            ->get();
    
        $posts->transform(function ($post) {
            $post->image = url($post->image);
            $post->user_image = $post->user_image ? url($post->user_image) : null; // Add the full URL for the user profile image if it exists
            return $post;
        });
    
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }
    
    

    /**
     * Add new post.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,100',
            'location' => 'required|string|max:100',
            'description' => 'string|max:100',
            'category'=>'required',
            'image' => 'required|image|max:2048',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()){
                $requestData = $request->all();
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images', $fileName, 'public');
                $requestData["image"] = 'storage/'.$path;
    
                $requestData["user_id"] = auth()->user()->id; // add authenticated user ID to post data
    
                $post = Post::create($requestData);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Post created successfully!',
                    'data' => $post
                ], 201);
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'You must include an image!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating post: '.$e->getMessage()
            ], 500);
        }
    }
    
    
    
    

    /**
     * Display a specific post.
     */

    public function show(string $id)
    {
        try{
        $post=Post::findorfail($id)->get();
        return response()->json($post);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }

    

    

    /**
     * Edit post .
     */
    public function update(Request $request,$id )
    {
        try{
        $validator = Validator::make($request->all(), [
            'title' => 'string|between:2,100',
            'location' => 'string|max:100',
            'description' => 'string|max:100',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);}
            $posts=Post::findorfail($id);

            $title= $request->title ?? $posts->title;
            $location= $request->location ?? $posts->location;
            $description= $request->description ?? $posts->description;
            $requestData=$request->image ?? $posts->image;
        
            $posts->update([
                'title'=>$title,
                'location'=>$location,
                'description'=> $description,
                'image'=>$requestData["image"],
            
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'UserProfile updated successfully',
            ]);   
        }catch(QueryException $e){
            return response()->json($e,500);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    }

    /**
     * Delete post.
     */
    public function destroy(string $id)
    {
        try{
        $post = Post::findOrFail($id);
    
        // Delete associated reports
        $post->reports()->delete();
    
        // Delete the post
        $post->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }

}