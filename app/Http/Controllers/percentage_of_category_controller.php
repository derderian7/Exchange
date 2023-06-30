<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Post;
use Exception;
use Illuminate\Database\QueryException;

class percentage_of_category_controller extends Controller
{
    
    public function percentage_of_categories(String $category_id){
        try{
=======
use Illuminate\Http\Request;
use App\Models\Post;
use DB;
class percentage_of_category_controller extends Controller
{
    public function percentage_of_categories()
    {
        $categories = ["clothes",
        "toys",
        "books",
        "electronic",
        "furniture"
      ]; 
        $result = [];

>>>>>>> d39e7a109bb3ff2a0ff79eadab2b9c9cf11fb0eb
        $totalPosts = Post::count();

        foreach ($categories as $category) {
            $categoryPosts = Post::where('category', $category)->count();
            $percentage = ($categoryPosts / $totalPosts);
            $roundedPercentage = round($percentage * 100, 2);

            $result[$category] = $roundedPercentage;
        }

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
};