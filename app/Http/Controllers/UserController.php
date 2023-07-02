<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Post;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    // get posts by the logged in user 
    public function usersPost_login() {
        try{
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();
        return response()->json($posts);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }
    // get posts by the id of the user

    public function usersPost_id($id) {
        try{
        $posts = DB::table('posts')->where('user_id', $id)->get();
        return response()->json($posts);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }

    // edit user profile 

    


public function updateUserProfile(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'string|between:2,15',
        'password' => 'string|min:6',
        'location' => 'string|max:100',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $userProfile = auth()->user();
    
    // Update name if provided
    if ($request->has('name')) {
        $userProfile->name = $request->name;
    }

    // Update password if provided
    if ($request->has('password')) {
        $userProfile->password = Hash::make($request->password);
    }

    // Update location if provided
    if ($request->has('location')) {
        $userProfile->location = $request->location;
    }

    $userProfile->save();

    return response()->json([
        'status' => 'success',
        'message' => 'User profile updated successfully',
        'user' => $userProfile
    ]);
}


////////////////////////////////////
    

    
    

    // delete user

    public function destroy(string $id)
    {
        try{
        //user::destroy($id);
        user::findorfail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }

    //show all users 

    public function ShowUserProfile(){
        try{
        $user=user::all();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
  
    public function getuserprofile(Request $request, $userId)
    {
        try{
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }
    
        $userInfo = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('feedbacks', 'users.id', '=', 'feedbacks.user_id')
            ->select(
                'users.name as user_name',
                'users.image as user_image',
                DB::raw('AVG(feedbacks.rating) as avg_rating')
            )
            ->where('users.id', $user->id)
            ->groupBy('users.name', 'users.image')
            ->get();
    
        $posts = Post::where('user_id', $user->id)->get();
    
        $userInfo->transform(function ($user) {
            $user->user_image = url('storage/' . $user->user_image);
            return $user;
        });
    
        $posts->transform(function ($post) {
            $post->image = url('storage/' . $post->image);
            return $post;
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully!',
            'data' => $userInfo,
            'posts' => $posts,
        ], 200);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
    



    public function getmyprofile(Request $request)
    {
        try{
        $user = $request->user();
    
        $userInfo = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin('feedbacks', 'users.id', '=', 'feedbacks.user_id')
            ->select(
                'users.name as user_name',
                'users.image as user_image',
                DB::raw('AVG(feedbacks.rating) as avg_rating')
            )
            ->where('users.id', $user->id)
            ->groupBy('users.name', 'users.image')
            ->get();
    
        $posts = Post::where('user_id', $user->id)->get();

        
        $userInfo->transform(function ($user) {
            $user->user_image = url('storage/' . $user->user_image);
            return $user;
        });
        



        $posts->transform(function ($post) {
            $post->image = url('storage/' . $post->image);
            return $post;
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully!',
            'data' => $userInfo,
            'posts' => $posts,
        ], 200);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
   
}