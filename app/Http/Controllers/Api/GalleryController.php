<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

/**
 * @OA\PathItem(path="/api/galleries")
 */
class GalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/banners",
     *     summary="Get list of galleries",
     *     @OA\Response(
     *         response=200,
     *         description="A list of galleries"
     *     )
     * )
     */
    public function index()
    {
        $galleries = Gallery::where('select' ,'gallery')->get();
        if (is_null($galleries)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        return response()->json($galleries);
    }

    /**
     * @OA\Get(
     *     path="/api/banners/{id}",
     *     summary="Get a gallery by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A gallery"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Gallery not found"
     *     )
     * )
     */
    public function show($id)
    {
        $gallery = Gallery::where('select' ,'gallery')->get()->find($id);

        if (is_null($gallery)) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }

        return response()->json($gallery);
    }
}
