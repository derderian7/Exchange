<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        // if ($UserProfile->image) {
        //     // Delete the user's current profile picture
        //     Storage::delete($UserProfile->image);
        // } else{
        // $requestData=$request->image ?? $UserProfile->image;
        // }
      // dd($x,$y,$z);
        $UserProfile->update([
            'name'=>$name,
            'password'=>Hash::make($password),
            'location'=> $location,
            //'image'=>$requestData,
            
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'UserProfile updated successfully',
        ]);
    }


    public function updateProfileImage(Request $request,$id )
{
    //dd($request->file('image'));
    //$user = Auth::user();
    
    
    
    $UserProfile=User::findorfail($id);
    if ($UserProfile->image) {
             // Delete the user's current profile picture
            Storage::delete($UserProfile->image);
        }
        else{
    
    // Save the uploaded file to storage
    $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images', $fileName, 'public');
                $requestData["image"] = '/storage/'.$path;
    
    // Update the user's profile image path in the database
    $UserProfile->image = $requestData;
    $UserProfile->save();

    return response()->json([
        'status' => 'success',
        'message' => 'UserProfileImage updated successfully',
    ]);

}

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
}