<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Post;
use DB;
use Exception;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    // display all users with their rating 
    public function showAllUsersProfile()
    {
        try {
            $users = User::all();
    
            $result = $users->map(function ($user) {
                $averageRating = Feedback::where('user_id', $user->id)->avg('rating');
                $user->average_rating = $averageRating; // Add average_rating property to the user object
                return $user;
            });
    
            return response()->json([
                'status' => 'success',
                'data' => $result,
            ]);
    
        } catch(QueryException $e) {
            return response()->json($e, 500);
        } catch(Exception $e) {
            return response()->json($e, 500);
        }
    }
    

// return all admins users 
public function GetAdmin()
    {
        try{
        $admin = User::select('name', 'email')->where('is_admin', 1)->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $admin,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }

        //show the 5 recent users 

        public function NewUsers(){
            try{
            $users =User::latest()->limit(4)->get();
            return response()->json($users);
        }catch(QueryException $e){
            return response()->json($e,500);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    
        }
            //count all users
    
    public function CountAllUsers()
    {
        try {
            $userCount = User::count();
            return response()->json([
                'status' => 'success',
                'data' => $userCount,
                ]
            );
        } catch (QueryException $e) {
            return response()->json($e, 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    // display admin profile  

    public function getadminprofile(Request $request,$admin)
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
