<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;
use Exception;
use Illuminate\Database\QueryException;

class percentage_of_category_controller extends Controller
{
    public function percentage_of_categories()
    {
        try{
        $categories = ["clothes",
        "toys",
        "books",
        "electronic",
        "furniture"
      ]; 
        $result = [];

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