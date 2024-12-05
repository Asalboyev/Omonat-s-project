<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class BennerController extends Controller
{


    public function index()
    {
        $galleries = Gallery::where('select','Construction products')->latest()->paginate(15);
        if (is_null($galleries)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        return response()->json($galleries);
    }

    public function banner()
    {
        $galleries = Gallery::where('select','Banner')->latest()->paginate(15);
        if (is_null($galleries)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        return response()->json($galleries);
    }

    public function show($id)
    {
        $gallery = Gallery::query()->get()->find($id);

        if (is_null($gallery)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }

        return response()->json($gallery);
    }

    public function t_index()
    {
        $galleries = Gallery::where('select','Household appliances')->latest()->paginate(15);
        if (is_null($galleries)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        return response()->json($galleries);
    }


    public function t_show($id)
    {
        $gallery = Gallery::query()->get()->find($id);

        if (is_null($gallery)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }

        return response()->json($gallery);
    }
}


