<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Http\Resources\TranslationResource;
use Illuminate\Http\Request;


class TranslationController extends Controller
{

    public function index()
    {
        $translations = Translation::all();
        $formattedTranslations = $translations->mapWithKeys(function ($translation) {
            return [$translation->key => $translation->val['en'] ?? $translation->val['ru'] ?? $translation->val['ar'] ?? null];
        });

        return response()->json($formattedTranslations);
    }

    public function getTranslations(Request $request, $lang)
    {
        // Validate $lang parameter to ensure it's one of the supported languages
        $supportedLanguages = ['en', 'ru', 'ar'];
        if (!in_array($lang, $supportedLanguages)) {
            return response()->json(['error' => 'Unsupported language.'], 400);
        }

        // Retrieve translations for the specified language
        $translations = Translation::all();

        // Map translations to format them as needed for the specified language
        $formattedTranslations = $translations->mapWithKeys(function ($translation) use ($lang) {
            return [
                $translation->key => $translation->val[$lang] ?? null
            ];
        });

        // Return formatted translations as JSON response
        return response()->json($formattedTranslations);
    }

    public function show($id)
    {
        $translation = Translation::find($id);

        if (is_null($translation)) {
            return response()->json(['message' => 'Translation not found'], 404);
        }

        return new TranslationResource($translation);
    }
}
