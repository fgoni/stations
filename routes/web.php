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

Route::get('/', function () {
    return view('battlestations', [
        'posts' => app(Reddit::class)->posts('battlestations'),
    ]);
});

Route::get('/battlestations', function () {
    return view('battlestations', [
        'posts' => app(Reddit::class)->posts('battlestations'),
    ]);
});

Route::get('/workstations', function () {
    return view('workstations', [
        'posts' => app(Reddit::class)->posts('workstations'),
    ]);
});

Route::get('/macsetups', function () {
    return view('macsetups', [
        'posts' => app(Reddit::class)->posts('macsetups'),
    ]);
});

Route::get('/averagebattlestations', function () {
    return view('battlestations', [
        'posts' => app(Reddit::class)->posts('AverageBattlestations'),
    ]);
});

Route::get('/shittybattlestations', function () {
    return view('battlestations', [
        'posts' => app(Reddit::class)->posts('shittybattlestations'),
    ]);
});

Route::get('/bookmarks', function () {
    return view('bookmarks.index');
})->name('bookmarks.index');

Route::get('{subreddit}', function (Reddit $reddit, $subreddit) {
    return view('battlestations', [
        'posts' => $reddit->posts($subreddit),
    ]);
});
