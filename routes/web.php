<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\FridgesController;
use App\Http\Controllers\MemosController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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
Route::get('/img', [ImagesController::class, 'index']);
Route::post('/upload', [ImagesController::class,'upload']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 自己開発routing
Route::get('/', [FridgesController::class, 'top']);
Route::get('/top', [FridgesController::class, 'top']);
Route::get('/fridge', [FridgesController::class, 'fridge']);
Route::post('/fridge_delete', [FridgesController::class, 'delete']);
Route::post('/minus', [FridgesController::class, 'minus']);
Route::post('/plus', [FridgesController::class, 'plus']);
Route::post('/dec', [FridgesController::class, 'dec']);
Route::post('/delete_ajax', [FridgesController::class, 'delete_ajax']);
Route::post('/fridge_insert', [FridgesController::class, 'insert']);
Route::post('/update_expiry', [FridgesController::class, 'expiry']);

Route::get('/recipe_index', [RecipesController::class, 'index']);
Route::post('/recipe_index', [RecipesController::class, 'search']);
Route::get('/recipe_show', [RecipesController::class, 'show']);
Route::get('/recipe_from_fridge', [RecipesController::class, 'index']);
Route::get('/recipe_create', [RecipesController::class, 'get_create']);
Route::post('/recipe_create', [RecipesController::class, 'post_create']);
Route::get('/recipe_edit', [RecipesController::class, 'edit']);
Route::post('/recipe_edit', [RecipesController::class, 'edit']);
Route::get('/recipe_delete', [RecipesController::class, 'delete']);
Route::post('/recipe_confirm', [RecipesController::class, 'confirm']);
Route::post('/recipe_insert', [RecipesController::class, 'insert']);
Route::post('/recipe_update', [RecipesController::class, 'update']);
Route::post('/recipe_delete', [RecipesController::class, 'delete']);

Route::get('/user', [UsersController::class, 'userpage']);
Route::post('/put_favorite', [UsersController::class, 'put_favorite']);
Route::post('/delete_favorite', [UsersController::class, 'delete_favorite']);

Route::post('/memo_insert', [MemosController::class, 'insert']);
Route::post('/memo_delete', [MemosController::class, 'delete']);
Route::post('/memo_addition', [MemosController::class, 'addition']);
Route::post('/memo_subtraction', [MemosController::class, 'subtraction']);
Route::post('/memo_checked', [MemosController::class, 'checked']);
Route::post('/memo_purchase', [MemosController::class, 'purchase']);
Route::post('/memo_fridge', [MemosController::class, 'fridge']);
Route::post('/to_fridge', [MemosController::class, 'to_fridge']);

require __DIR__.'/auth.php';
