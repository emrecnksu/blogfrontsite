<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\UserProfileController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('register', [UserController::class, 'signup'])->name('register.form');
Route::post('register', [UserController::class, 'register'])->name('register');

Route::get('login', [UserController::class, 'loginForm'])->name('login.form');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('post/{slug}', [HomeController::class, 'show'])->name('post.show');

Route::get('profile', [UserProfileController::class, 'show'])->name('profile');
Route::post('profile/update', [UserProfileController::class, 'update'])->name('profile.update');
Route::post('profile/delete', [UserProfileController::class, 'delete'])->name('profile.delete');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::post('/comments/{id}', [CommentController::class, 'delete'])->name('comments.delete');

Route::get('categories/{slug}/posts', [HomeController::class, 'categoryPosts'])->name('category.posts');

Route::get('content/{type}', [HomeController::class, 'showContent'])->name('content.show');
