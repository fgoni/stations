<?php

//use CodeWizz\RedditAPI\RedditAPI;
use App\Services\Reddit;
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

Route::get('/', function (Reddit $reddit) {
    $posts = $reddit->posts()->filter(function($post){
        return str_contains($post->url, 'i.redd.it');
    });
    return view('battlestations', [
        'posts' => $posts,
    ]);
});

Route::get('{subreddit}', function (Reddit $reddit, $subreddit) {
    $posts = $reddit->posts($subreddit)->filter(function($post){
        return str_contains($post->url, 'i.redd.it');
    });
    return view('battlestations', [
        'posts' => $posts,
    ]);
});
