<?php

use App\Http\Controllers\MyTestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Post\Create as PostCreate;
use App\Http\Livewire\Post\Update as PostUpdate;
use App\Http\Livewire\Post\View as PostView;
use App\Http\Livewire\Post\Listing as PostListing;
use App\Http\Livewire\Posts;
use App\Http\Livewire\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::prefix('user')->group(function () {
    Route::match(['GET', 'POST'], '/login', [UserController::class, 'login'])->name('user.login');
    Route::get('/signup', [UserController::class, 'signup'])->name('user.signup');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
});

Route::prefix('posts')->group(function () {
    Route::get('/', Posts::class)->name('posts');
    Route::get('create', Posts::class)->name('post.create');
    Route::get('view/{id}', Posts::class)->name('post.view');
    Route::get('edit/{id}', Posts::class)->name('post.edit');
});

// Route::middleware(['auth:sanctum', 'web.auth'])->group(function () {
// });

// Route::prefix('posts')->group(function () {
//     Route::get('/', PostListing::class)->name('posts');
//     Route::get('create', PostCreate::class)->name('post.create');
//     Route::get('edit/{id}', PostUpdate::class)->name('post.edit');
//     Route::get('view/{id}', PostView::class)->name('post.view');
// });
