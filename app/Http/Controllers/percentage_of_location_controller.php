<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class percentage_of_location_controller extends Controller
{
    public function percentage_of_location(String $location){
        $totalPosts = Post::count();
        $locationPosts = Post::where('location', $location)->count();
        $percentage = ($locationPosts / $totalPosts) * 100;
        $roundedPercentage = round($percentage, 2);
        
        return response()->json([
            'status' => 'success',
            'data' => $roundedPercentage,
        ]);
    }
};