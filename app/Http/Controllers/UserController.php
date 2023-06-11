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

   

    public function updateUserProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|between:2,15',
            'password' => 'string|min:6',
            'location' => 'string|max:100',
           
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $userProfile = User::findOrFail($id);
    
        // Update name, password, and location
        $userProfile->name = $request->input('name', $userProfile->name);
        $userProfile->password = $request->input('password') ? Hash::make($request->input('password')) : $userProfile->password;
        $userProfile->location = $request->input('location', $userProfile->location);
    
        // Update profile picture if provided
        
    
        $userProfile->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'User profile updated successfully',
        ]);
    }
    

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
        $imagePath = '/storage/' . $path;
    
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