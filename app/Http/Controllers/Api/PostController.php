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
                'phone' => $about->phone,
                'title' => $about->title,
                'subtitle' => $about->subtitle,
                'apple_link' => $about->apple_link,
                'and_link' => $about->and_link,
                'app_link' => $about->app_link,
                'tg_link' => $about->tg_link,
                'insta_link' => $about->insta_link,
                'you_link' => $about->you_link,
                'double_description' => $about->double_description,
                'updated_at' => $about->employees,
                'description' => json_decode($about->description, true), // JSON formatidagi descriptionsni o'qish
                'double_description' => json_decode($about->double_description, true), // JSON formatidagi descriptionsni o'qish
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
