<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Post;
//use App\Models\Category;
//use DB;
class percentage_of_category_controller extends Controller
{
    public function percentage_of_categories(String $category_id){
        $totalPosts = Post::count();
        $categoriesPosts = Post::where('category_id', $category_id)->count();
       $percentage = ($categoriesPosts / $totalPosts) ;
     $roundedPercentage = round($categoriesPosts, 2);
        
        return response()->json([
            'status' => 'success',
            'data' => $roundedPercentage*100,
        ]);
    }
};