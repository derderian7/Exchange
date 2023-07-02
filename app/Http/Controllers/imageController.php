<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Post;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class imageController extends Controller
{

// edit the users profile image

    public function updateProfileImage(Request $request)
    {
        try{
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
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }


    // delete the user's profile image
    public function deleteImage(string $id)
    {
        try{
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
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }
    

}
