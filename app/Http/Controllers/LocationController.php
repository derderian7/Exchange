<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;
use Illuminate\Database\QueryException;

class LocationController extends Controller
{
    public function percentage_of_locations()
    {
        try{
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

            $result[$location] = $roundedPercentage;
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

    public function Count_of_locations()
    {
        try{
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
            

            $result[$location] = $locationPosts;
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
