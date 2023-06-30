<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;
use Exception;
use Illuminate\Database\QueryException;
class percentage_of_location_controller extends Controller
{
<<<<<<< HEAD
   
    
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
    
    
=======
    public function percentage_of_locations()
    {
        $locations = ["Aleppo",
        "Damascus",
        "Hama",
        "Tartus",
        "Latakia",
        "Idlib",
        "Homs",
        "Deir Ez-Zor",
        "Daraa ",
        "As-Suwayda",
        "Raqqa ",
        "Quneitra",
        "Al-Hasakah",
        "Rif Dimashq"]; 
        $result = [];

        $totalPosts = Post::count();

        foreach ($locations as $location) {
            $locationPosts = Post::where('location', $location)->count();
            $percentage = ($locationPosts / $totalPosts);
            $roundedPercentage = round($percentage * 100, 2);
>>>>>>> d39e7a109bb3ff2a0ff79eadab2b9c9cf11fb0eb

            $result[$location] = $roundedPercentage;
        }

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }
};
