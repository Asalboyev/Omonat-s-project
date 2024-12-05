<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LangsController;
use App\Http\Controllers\Admin\TranslationsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\PortfoliosController;
use App\Http\Controllers\Admin\TeamsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\GalleriesController;
use App\Http\Controllers\Admin\OtziviController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\BreandController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('langs', [LangsController::class, 'index'])->name('langs.index');
    Route::get('/langs/create', [LangsController::class, 'create'])->name('lang.create');
    Route::post('/langs/store', [LangsController::class, 'store'])->name('lang.store');
    Route::post('/langs/destroy/{id}', [LangsController::class, 'destroy'])->name('lang.destroy');
    Route::get('/translations', [TranslationsController::class, 'index'])->name('translations.index');
    Route::post('/translations/update/{id}', [TranslationsController::class, 'tr_update'])->name('translation.tr_update');
    Route::post('/translations/destroy/{id}', [TranslationsController::class, 'destroy'])->name('translation.destroy');
    Route::get('/translations/{id}/create', [TranslationsController::class, 'create'])->name('translation.create');
    Route::post('/translations/{id}/update', [TranslationsController::class, 'update'])->name('translation.update');
    Route::get('/translations/search', [TranslationsController::class, 'search'])->name('translation.search');
    Route::post('translations', [TranslationsController::class, 'group_store'])->name('group.store');
    Route::get('/translations/{id}', [TranslationsController::class, 'group_show'])->name('group.show');
    Route::get('/zayavka/search', [OtziviController::class, 'z_search'])->name('zayavka.search');

    Route::post('/zayavka/status', [OtziviController::class, 'status'])->name('zayavka.status');

    Route::get('zayavkas', [OtziviController::class, 'z_index'])->name('z.index');
    Route::post('/zayavkas/destroy/{id}', [OtziviController::class, 'z_destroy'])->name('zayavkas.destroy');
    Route::post('zayavkas/{id}/deactivate', [OtziviController::class, 'deactivate'])->name('deactivate');
     Route::get('/information',[OtziviController::class,'in_index'])->name('information.upload');
    Route::put('/information/{id}', [OtziviController::class, 'in_store'])->name('information.store');
    Route::post('/info',[OtziviController::class,'ajax'])->name('information.ajax');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
