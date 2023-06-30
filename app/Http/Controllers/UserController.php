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

class UserController extends Controller
{
    // get posts by the logged in user 

    public function usersPost_login() {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();
        return response()->json($posts);
    }
    // get posts by the id of the user

    public function usersPost_id($id) {
        $posts = DB::table('posts')->where('user_id', $id)->get();
        return response()->json($posts);
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
    

    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $user = auth()->user();
        
        // Delete the previous profile image if it exists
        if ($user->image) {
            $previousImagePath = public_path($user->image);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
    
        $fileName = time() . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $fileName, 'public');
        $imagePath = 'storage/' . $path;
    
        $user->image = $imagePath;
        $user->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Profile image updated successfully',
            'user' => $user,
        ]);
    }
    

    // delete user

    public function destroy(string $id)
    {
        //user::destroy($id);
        user::findorfail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
        ]);
    }

    //show all users 

    public function ShowUserProfile(){
        $user=user::all();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
    public function GetAdmin()
    {
        $admin = User::select('name', 'email')->where('is_admin', 1)->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $admin,
        ]);
    }
    

    //show recent users 

    public function NewUsers(){
        
        $users =User::latest()->limit(5)->get();
        return response()->json($users);

    }

    // count recent users

    public function NewUsers2(){
        $startDate = now()->subDays(7); // get the date 7 days ago
        $endDate = now(); // get the current date
        $userCount =User::whereBetween('created_at', [$startDate, $endDate])->count();
        return response()->json($userCount);
    }

    //count users with no exchange 
    
    public function visitors(){

            $userCount = DB::table('users')->whereNotIn('id', function($query) {
                    $query->select('user_id')
                        ->from('posts')
                        ->where('post_status', 0);
                })->count();
                return response()->json($userCount);
    }

    public function deleteImage(string $id)
{
    $user = User::find($id);

    if (!$user->image) {
        return response()->json([
            'success' => false,
            'message' => 'User does not have an image!'
        ], 404);
    }

    $imagePath = $user->image;

    // Check if the file exists before attempting to delete it
    if (Storage::exists($imagePath)) {
        Storage::delete($imagePath);
    }

    $user->image = null;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Image deleted successfully!',
        'data' => $user
    ], 200);
}


  /*  public function showProfile(Request $request)
    {
        $user = $request->user();
        
        $name = $user->name != null ? $user->name : 'Unknown';
        $rating = Feedback::where('user_id', $user->id)->avg('rating');
        $posts = Post::where('user_id', $user->id)->get();

        return response()->json([
            'name' => $name,
            'rating'=>$rating,
            'posts'=>$posts
            
        ]);
    }*/


    public function getuserprofile(Request $request, $userId)
    {
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
    }
    



    public function getmyprofile(Request $request)
    {
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
    }
    public function getadminprofile(Request $request,$admin)
    {
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
    }
    
    
    
    
    
    



}