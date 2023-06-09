<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
  

class ReportController extends controller{

    public function store(Request $request)
    {
        $report = Report::create([
            'post_id' => $request->post_id,
            
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'report stored successfully',
            ]);
    }
    public function index()
    {
        $reports=Report::all();
        return response()->json([
            'status' => 'success',
            'data' => $reports,
        ]);
    }
  /*  public function report_count($id)
{
    $post = Post::find($id);
    if (!$post) {
        return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
    }

    $reportCount = $post->reports()->count();

    return response()->json([
        'status' => 'success',
        'data' => $reportCount,
    ]);
}
*/


public function getPosts()
{
    $posts = DB::table('posts')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->leftJoin('reports', 'posts.id', '=', 'reports.post_id')
        ->select('posts.id', 'posts.user_id', 'users.name as user_name', DB::raw('count(reports.id) as report_count'))
        ->groupBy('posts.id', 'posts.user_id', 'users.name')
        ->get();
       // dd($posts);
       $posts = $posts->toArray();

       return response()->json([
        'success' => true,
        'message' => 'Posts retrieved successfully!',
        'data' => $posts
    ], 200);
    
}


}