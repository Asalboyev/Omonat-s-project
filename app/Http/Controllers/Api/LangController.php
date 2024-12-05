<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Lang;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/langs")
 */
class LangController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/langs",
     *     summary="Get list of languages",
     *     @OA\Response(
     *         response=200,
     *         description="A list of languages"
     *     )
     * )     buni  route qani
     */
    public function index()
    {
        $langs = Lang::all();
        return response()->json($langs);
    }

    /**
     * @OA\Get(
     *     path="/api/langs/{id}",
     *     summary="Get a language by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A language"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Language not found"
     *     )
     * )
     */
//  ko'rsatganlarimni  tilt en null bo'ganligi uchun runi chiardida men gam shundaqa qilishm kerak xozr sizga ishlasini ko'rsataman  ko'rdizmi aka ?
    public function show($id)
    {
        $lang = Lang::find($id);

        if (is_null($lang)) {
            return response()->json(['message' => 'Language not found'], 404);
        }

        return response()->json($lang);
    }
}
