<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class FeedbackController extends Controller
{

  // create a rating for an user 

    public function store(Request $request)
    {
        try{
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            
        ]);

        Feedback::create($validatedData);

        return response()->json(['message' => 'Feedback stored successfully']);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }


// get the average rating for a specific user 


    public function getRating($userId)
    {
        try{
        $rating = Feedback::where('user_id', $userId)->avg('rating');

        return response()->json(['rating' => $rating]);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }


// Get rating for the currently authenticated user


    public function getMyRating()
{
    try{
    // Get the currently authenticated user
    $user = auth()->user();

    // Get the user's average rating
    $rating = Feedback::where('user_id', $user->id)->avg('rating');

    // Return the rating as a JSON response
    return response()->json(['rating' => $rating]);
    }catch(QueryException $e){
    return response()->json($e,500);
  }catch(Exception $e){
    return response()->json($e,500);
  }
}
}

