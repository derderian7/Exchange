<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use DB;
class percentage_of_category_controller extends Controller
{
  
  
 
        
    
            public function percentage_clothes(){
          
                $count = Post::where('categories_id', '1')->count();
                $all_Categories=Post::all('categories_id')->count();
                $percentage=$count/$all_Categories;
           
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage*100,
    
                ]);
            }
            public function percentage_furniture(){
                $count = Post::where('categories_id', '2')->count();
                $all_Categories=Post::all('categories_id')->count();
                $percentage=$count/$all_Categories;
        
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage*100,
                ]);
            }
            public function percentage_stationery(){
                $count = Category::where('Category', 'stationery')->count();
                $all_Categories=Category::all()->count();
                $percentage=$count/$all_Categories;
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage*100,
                ]);
            }
                public function percentage_devices(){
                    $count = Category::where('Category', 'devices')->count();
                    $all_Categories=Category::all()->count();
                    $percentage=$count/$all_Categories;
                    return response()->json([
                        'status' => 'success',
                        'data' => $percentage,
                    ]);
            }
            public function percentage_toys(){
                $count = Category::where('Category', 'toys')->count();
                $all_Categories=Category::all()->count();
                $percentage=$count/$all_Categories;
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage,
                ]);
        }
        
        
        
        }
        
    
    

