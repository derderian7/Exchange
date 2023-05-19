<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //function to insert use posts in user profile 
    public function usersPost() {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();

    }
    public function EditUserProfile(){


    }
    public function updateUserProfile(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,15',
           
           // ' profile image' => //later//
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $UserProfile=User::findorfail($id);
        $UserProfile->update([
            'name'=>$request->name,
          //profile-imagelater
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'UserProfile updated successfully',
        ]);
    
    
    }
}
