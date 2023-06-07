<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Post;
//use App\Models\Category;
//use DB;
class percentage_of_category_controller extends Controller
{
    public function percentage_of_categories(String $category){
        $totalPosts = Post::count();
        $categoriesPosts = Post::where('category', $category)->count();
        $percentage = ($categoriesPosts / $totalPosts) * 100;
        $roundedPercentage = round($percentage, 2);
        
        return response()->json([
            'status' => 'success',
            'data' => $roundedPercentage,
        ]);
    }
};