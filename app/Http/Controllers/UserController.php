<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // get posts by the logged in user 

    public function usersPost() {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();
        return response()->json($posts);
    }

    // edit user profile 

    public function updateUserProfile(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,15',
            'password'=>'string|min:6',
            'location'=>'string|max:100',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $UserProfile=User::findorfail($id);

        $location= $request->location ?? $UserProfile->location;
        $password= $request->password ?? $UserProfile->password;
        $name= $request->name ?? $UserProfile->name;
        $requestData=$request->image ?? $UserProfile->image;

      // dd($x,$y,$z);
        $UserProfile->update([
            'name'=>$name,
            'password'=>Hash::make($password),
            'location'=> $location,
            'image'=>$requestData["image"],
            
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'UserProfile updated successfully',
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
}