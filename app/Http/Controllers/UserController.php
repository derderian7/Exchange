<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //function to insert user posts in user profile 
    public function usersPost() {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();
        return response()->json($posts);
    }
    
    public function updateUserProfile(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,15',
            'password'=>'string|min:6',
            'location'=>'string|max:100',
           // ' profile image' => //later//
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
       
        $UserProfile=User::findorfail($id);

        $location= $request->location ?? $UserProfile->location;
        $password= $request->password ?? $UserProfile->password;
        $name= $request->name ?? $UserProfile->name;
      // dd($x,$y,$z);
        $UserProfile->update([
            'name'=>$name,
            'password'=>Hash::make($password),
            'location'=> $location,
          //profile-imagelater
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'UserProfile updated successfully',
        ]);
    
    
    }
    public function destroy(string $id)
    {
        //user::destroy($id);
        user::findorfail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'user deleted successfully',
        ]);
    }
    public function ShowUserProfile(){
        $user=user::all();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    } 
}
