<?php

namespace App\Http\Controllers;

use App\Models\Post;
use DB;
use Illuminate\Http\Request;
use Validator;
use App\Events\NewNotification;

class PostController extends Controller
{
    /**
     * Display all posts.
     */
    public function index()
    {
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as user_name', 'users.image as user_image')
            ->get();
    
        $posts->transform(function ($post) {
            $post->image = url($post->image);
            $post->user_image = $post->user_image ? url($post->user_image) : null; // Add the full URL for the user profile image if it exists
            return $post;
        });
    
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ]);
    }
    
    
    
    
    

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Add new post.
     */
    public function store(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|between:2,100',
                'location' => 'required|string|max:100',
                'description' => 'string|max:100',
                
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            try {
                if ($request->hasFile('image') && $request->file('image')->isValid()){
                $requestData = $request->all();
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('images', $fileName, 'public');
           $requestData["image"] = 'storage/'.$path;


                
                $post = Post::create($requestData);
          
            
                return response()->json([
                    'success' => true,
                    'message' => 'Post created successfully!',
                    'data' => $post
                ], 201);}
                else{
                    return response()->json([
                        'success' => false,
                        'message' => 'you have to add an image!',]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating post: '.$e->getMessage()
                ], 500);
            }
        }
    
    
        /*  return response()->json([
            'status' => 'success',
            'message' => 'Post added successfully',
        ]);*/
    

    /**
     * Display a specified post.
     */

    public function show(string $id)
    {
        $post=Post::findorfail($id)->get();
        return response()->json($post);
    }

    /**
     * Post availability.
     */

    public function edit_post_status(string $id)
    {
        $post=Post::findorfail($id);
        $post_status=$post->post_status;
        if ($post_status==0){
            $post->update(['post_status'=>'1']);
            
            return response()->json([
            'status' => 'success',
            'message' => 'Posted on the ended page',
            ]);
        }
        elseif ($post_status==1) {
            DB::table('transaction')->insert([
                'post_id' => $post,
            ]);

            return response()->json([
            'status' => 'success',
            'message' => 'Posted on the ending page',
            ]);

        }
    }

    /**
     * Edit post .
     */
    public function update(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|between:2,100',
            'location' => 'string|max:100',
            'description' => 'string|max:100',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);}
            $posts=Post::findorfail($id);

            $title= $request->title ?? $posts->title;
            $location= $request->location ?? $posts->location;
            $description= $request->description ?? $posts->description;
            $requestData=$request->image ?? $posts->image;
          // dd($x,$y,$z);
            $posts->update([
                'title'=>$title,
                'location'=>$location,
                'description'=> $description,
                'image'=>$requestData["image"],
            
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'UserProfile updated successfully',
            ]);   
    }

    /**
     * Delete post.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
    
        // Delete associated reports
        $post->reports()->delete();
    
        // Delete the post
        $post->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ]);
    }
    
    /*posts by specific user_id */

   /* public function VisitedUserPosts(string $id){
        $posts = Post::where('user_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ]);
    }*/
    
    
/*count posts by month */

public function countPostsByMonth()
{
    $postsByMonth = Post::countPostsByMonth();
    return response()->json([
        'status' => 'success',
        'data' => $postsByMonth,
    ]);
    
    
}

// count how many exchange we have " total transactions" 

public function countPosts()
{
    $count = Post::where('post_status', 1)->count();
    return response()->json([
        'status' => 'success',
        'data' => $count,
    ]);
    
}

// recent transactions  

public function RecentTransactions()
{
    $posts = Post::where('post_status', 1)
                ->latest()
                ->take(4)
                ->with('user')
                ->get();
    
                return response()->json([
                    'status' => 'success',
                    'data' => $posts,
                ]);
}

public function exchange(Request $request, $postId)
{
    // Get the post that user1 wants to exchange
    $post = Post::find($postId);
  // Get the authenticated user
  $user1 = $request->user();


    // Get the user that owns the post
    $user2 = $post->user;

    // Send a notification to user2 that user1 wants to exchange with their post
    $data = [
        'title' => 'Exchange Request',
        'message' => 'User1 wants to exchange with your post.',
        'action_text' => 'Accept',
        'action_url' => url("/posts/{$postId}/accept-exchange"),
    ];
    event(new NewNotification($user2, $data));
    return response()->json([
        'status' => 'success',
        'data' => $data,
    ]);
}


public function acceptExchange(Request $request, $postId)
{
    // Get the post that user2 wants to exchange
    $post = Post::find($postId);
    
    //$user1 = $post->user;
    $user1 = $request->user();

    // Send a notification to user1 that user2 wants to exchange with their post
    $data = [
        'title' => 'Exchange Request Accepted',
        'message' => 'User2 has accepted your exchange request.',
        'action_text' => 'Accept',
        'action_url' => url("/posts/{$postId}/complete-exchange"),
        'posts' => $user1->posts()->get(),
    ];
    event(new NewNotification($user1, $data));

// Return a JSON response with user1's posts for user2 to choose from
    $posts = $user1->posts()->get();
    return response()->json
    (['posts' => $posts,
      'notification'=>$data,

    ]);
}


public function completeExchange(Request $request, $postId)
{
    // Get the post that the user wants to exchange
    $post = Post::find($postId);

    // Get the ID of the post that the user wants to exchange with
    $exchangePostId = $request->input('post_id');

    // Get the post that the user wants to exchange with
    $exchangePost = Post::find($exchangePostId);
    // Only exchange the posts if both $post and $exchangePost are not null
    if ($post && $exchangePost) {

        // Update the exchanged posts' statuses
        $post->update(['post_status' => 1]);
        $exchangePost->update(['post_status' => 1]);

        // Return a success message
        return response()->json(['message' => 'Exchange complete.']);
    } else {
        // Return an error message if one or both of the posts are null
        return response()->json(['error' => 'One or both of the posts do not exist.'], 404);
    }

}
}