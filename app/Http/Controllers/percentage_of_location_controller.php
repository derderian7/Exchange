<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class percentage_of_location_controller extends Controller
{
    public function percentage_of_location(String $Location){
        $count = Post::where('location', '$Location')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Hama(){
        $count = Post::where('location', 'Hama')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Tartus(){
        $count = Post::where('location', 'Tartus')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Latakia(){
        $count = Post::where('location', 'Latakia')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Idlib(){
        $count = Post::where('location', 'Idlib')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Homs(){
        $count = Post::where('location', 'Homs')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_DeirEz_Zo(){
        $count = Post::where('location', 'Deir Ez-Zo')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Daraa(){
        $count = Post::where('location', 'Daraa')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_As_Suwayda(){
        $count = Post::where('location', 'As-Suwayda')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Raqqa(){
        $count = Post::where('location', 'Raqqa')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Quneitra(){
        $count = Post::where('location', 'Quneitra')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Al_Hasakah(){
        $count = Post::where('location', 'Al-Hasakah')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Rif_Dimashq(){
        $count = Post::where('location', 'Rif Dimashq')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    public function percentage_Aleppo(){
        $count = Post::where('location', 'Aleppo')->count();
        $all_locations=Post::all('location')->count();
        $percentage=$count/$all_locations;

        return response()->json([
            'status' => 'success',
            'data' => $percentage*100,
        ]);
    }
    }
