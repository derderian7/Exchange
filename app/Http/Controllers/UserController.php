<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //function to insert use posts in user profile 
    public function usersPost() {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();

    }
    
    public function updateUserProfile(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,15',
            'password'=>'required|string|min:6|confirmed',
            'location'=>'required|string|max:100',
           
           // ' profile image' => //later//
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $UserProfile=User::findorfail($id);
        $UserProfile->update([
            'name'=>$request->name,
            'password'=>$request->password,
            'location'=>$request->location,+

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
