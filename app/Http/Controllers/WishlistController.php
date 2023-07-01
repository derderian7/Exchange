<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
        {
            public function addToWishlist(Request $request, $postId)
            {
                // Get the authenticated user
                $user = $request->user();
        
                // Find the post by ID
                $post = Post::findOrFail($postId);
        
                // Check if the post is already in the user's wishlist
                $isInWishlist = Wishlist::where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->exists();
        
                if ($isInWishlist) {
                    return response()->json(['message' => 'The post is already in your wishlist'], 400);
                }
        
                // Add the post to the user's wishlist
                $wishlist = new Wishlist();
                $wishlist->user_id = $user->id;
                $wishlist->post_id = $post->id;
                $wishlist->save();
        
                return response()->json(['message' => 'The post has been added to your wishlist'], 200);
            }
           


            public function index()
            {
                // Get the authenticated user
                $user = Auth::user();
        
                // Retrieve the posts in the user's wishlist
                $wishlist = $user->wishlist()->with('post')->get();
        
                // Extract the post data from the wishlist
                $posts = $wishlist->pluck('post');
        
                // Return the wishlist posts as a JSON response
                return response()->json(['wishlist' => $posts], 200);
            }
}


        
    
    