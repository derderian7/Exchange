<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;
use Exception;
use Illuminate\Database\QueryException;
class percentage_of_location_controller extends Controller
{
   
    
        public function percentage_of_location(String $location)
        {
            try{
            $totalPosts = Post::count();
            $locationPosts = Post::where('location', $location)->count();
            $percentage = ($locationPosts / $totalPosts) ;
            $roundedPercentage = round($percentage, 2);
    
            return response()->json([
                'status' => 'success',
                'data' => $roundedPercentage* 100,
            ]);
        }catch(QueryException $e){
            return response()->json($e,500);
          }catch(Exception $e){
            return response()->json($e,500);
          }
        }
    
    


};