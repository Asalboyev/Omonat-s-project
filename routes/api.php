<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZayavkaController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\LangController;
use App\Http\Controllers\Api\OtziviController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\PortfolioCategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ServicController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\BennerController;
use App\Http\Controllers\SearchController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('search', [SearchController::class, 'search']);

//Route::apiResource('faq', FaqController::class);
Route::apiResource('langs', LangController::class);

// bu yo'nalish o'chirilganmi?
Route::get('about', [PostController::class, 'about'])->name('about');


Route::get('/test-email', [ZayavkaController::class, 'testEmail']);

Route::apiResource('services', ServicController::class);
Route::apiResource('translations/', TranslationController::class);
Route::get('/translations/{lang}', [TranslationController::class, 'getTranslations']);
Route::apiResource('translations', TranslationController::class);
Route::apiResource('zayavkas', ZayavkaController::class);


