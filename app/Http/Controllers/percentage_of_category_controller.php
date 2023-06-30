<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Database\QueryException;

class percentage_of_category_controller extends Controller
{
    
    public function percentage_of_categories(String $category_id){
        try{
        $totalPosts = Post::count();
        $categoriesPosts = Post::where('category_id', $category_id)->count();
       $percentage = ($categoriesPosts / $totalPosts) ;
     $roundedPercentage = round($categoriesPosts, 2);
        
        return response()->json([
            'status' => 'success',
            'data' => $roundedPercentage*100,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
};