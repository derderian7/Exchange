<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request, Post $post)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Check if the post already exists in the user's wishlist
        if (!$user->wishlist->contains($post->id)) {
            // Attach the post to the user's wishlist
            $user->wishlist()->attach($post->id);
        }

        return redirect()->back()->with('success', 'Post added to wishlist.');
    }
}

