<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\About;

/**
 * @OA\PathItem(path="/api/posts")
 */
class PostController extends Controller
{

    public function index()
    {
        $posts = Post::where('status', 'Active')
        ->latest()
        ->paginate(8);
        return response()->json($posts);
    }



    public function about()
    {
        $about = About::all()->map(function($about) {
            return [
                'id' => $about->id,
                'satisfied_clients' => $about->satisfied_clients,
                'photo' => $about->photo,
                'conducted_master_classes' => $about->conducted_master_classes,
                'cooperation_with_clinics' => $about->cooperation_with_clinics,
                'employees' => $about->employees,
                'updated_at' => $about->employees,
                'descriptions' => json_decode($about->descriptions, true), // JSON formatidagi descriptionsni o'qish
                // boshqa maydonlar, agar kerak bo'lsa
            ];
        });

        return response()->json($about);
    }



    public function show($slug)
{
    // Find the post by slug
    $post = Post::where('slug', $slug)->first();

    if (is_null($post)) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    return response()->json([
        'data' => [
            'id' => $post->id,
            'title' => $post->title,
            'photo' => $post->photo,
            'status' => $post->status,
            'slug' => $post->slug,
            'view' => $post->view,
            'descriptions' => $post->descriptions,
            'created_at' => $post->created_at->toDateTimeString(), // Format to string for consistency
            'updated_at' => $post->updated_at->toDateTimeString(), // Format to string for consistency
        ]
    ]);
}


}