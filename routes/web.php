<?php

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
    return view('welcome');
});

Auth::routes();

// All routes in this group are protected by the auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('categories', 'CategoriesController');
    Route::resource('posts', 'PostsController')->middleware('auth');

    Route::resource('tags', 'TagsController');

    Route::get('trashed-posts', 'PostsController@trashed')->name('trashed-posts.index'); //name() gives a route name, so in the blade files you go to a route via the route names with route() instead of the route itself. To check all route names 'art route:list'

    Route::put('restore-post/{post}', 'PostsController@restore')->name('restore-post');
});