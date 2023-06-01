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
                $count = Post::where('categories_id', '3')->count();
                $all_Categories=Post::all('categories_id')->count();
                $percentage=$count/$all_Categories;
        
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage*100,
                ]);
            }
                public function percentage_devices(){
                    $count = Post::where('categories_id', '4')->count();
                    $all_Categories=Post::all('categories_id')->count();
                    $percentage=$count/$all_Categories;
            
                    return response()->json([
                        'status' => 'success',
                        'data' => $percentage*100,
                    ]);
            }
            public function percentage_toys(){
                $count = Post::where('categories_id', '5')->count();
                $all_Categories=Post::all('categories_id')->count();
                $percentage=$count/$all_Categories;
        
                return response()->json([
                    'status' => 'success',
                    'data' => $percentage*100,
                ]);
        }
        
        
        
        }
        
    
    

