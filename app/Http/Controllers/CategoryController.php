<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{

    // get the percentage of each catogery for all posts
public function percentage_of_categories()
{
    try {
        $categories = [
            "clothes",
            "toys",
            "books",
            "electronic",
            "furniture"
        ]; 

        $result = [];
        $totalPosts = Post::count();

        if ($totalPosts == 0) {
            throw new Exception('No posts found.');
        }

        foreach ($categories as $category) {
            $categoryPosts = Post::where('category', $category)->count();
            $percentage = ($categoryPosts / $totalPosts);
              $roundedPercentage = round($percentage * 100, 2);

            $result[$category] = $roundedPercentage;
        }

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    } catch(QueryException $e) {
        return response()->json($e, 500);
    } catch(Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
// count the number of categories 
    public function CountAllCategories()
    {
        try{
        $categories = ["clothes",
        "toys",
        "books",
        "electronic",
        "furniture"
    ]; 
    $count = count($categories);

        return response()->json([
            'status' => 'success',
            'data' => $count,
        ]);
    }catch(QueryException $e){
        return response()->json($e,500);
    }catch(Exception $e){
        return response()->json($e,500);
    }
    }

    


};