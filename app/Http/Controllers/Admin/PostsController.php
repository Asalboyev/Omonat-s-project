<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lang;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Psy\bin;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $languages = Lang::all();
        $posts = Post::query()->paginate(10);

        if ($request->ajax()) {
            $status = $request->get('status', 'all');
            if ($status === 'all') {
                $posts = Post::paginate(10);
            } else {
                $posts = Post::where('status', $status)->paginate(10);
            }

            return response()->json(['posts' => $posts]);
        }
        return view('admin.posts.index',compact('languages','posts'));
    }

    public function ajax(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('upload/posts-images', $imageName, 'public');

            return response()->json(['success' => $path]);
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Lang::all();
        return view('admin.posts.create',compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title.en' => 'required'
        ]);

        $data = $request->all();

        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }

        Post::create($data);
        return redirect()->route('admin.posts.index')->with(['message' => 'Successfully added!']);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $languages = Lang::all();
        return view('admin.posts.edit',compact('post','languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title.en' => 'required'
        ]);
        $post = Post::findOrFail($id);
        $data = $request->all();
        if ($request->has('image_name')) {
            $data['photo'] = $request->input('image_name');
        }
        $post->update($data);

        return redirect()->route('admin.posts.index')->with(['message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Rasmlar mavjud bo'lsa, ularni o'chirish
        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with(['message' => 'Successfully deleted!']);
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->move(public_path('site/images/posts/'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('site/images/posts/' . $fileName); // URL uchun asset funksiyasidan foydalanamiz
            $msg = 'Image successfully uploaded';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function filterProducts(Request $request)
    {
        $status = $request->query('status');

        if ($status === 'all') {
            $posts = Post::all();
        } else {
            $posts = Post::where('status', $status)->get();
        }

        return response()->json(['posts' => $posts]);
    }

    public function search(Request $request) {
        $search_term = mb_strtolower($request->search);

        // Search in Category models
        $categories = Post::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('status', 'like', '%' . $search_term . '%')->get();

        // Merge all results
        $posts = collect()
            ->merge($categories);

        $search_word = $request->search;

        return view('admin.posts.search', compact('posts', 'search_word'));
    }
    public function status(Request $request) {
        $status = $request->input('status'); // select tanlov qiymati
        $query = Post::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $posts = $query->paginate(10);

        return view('admin.posts.status', compact('posts', ));
    }


}
