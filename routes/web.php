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

Route::get('/', '\App\Http\Controllers\Common\Navigation\IndexController@index');
Route::get('/navigation/contribute', '\App\Http\Controllers\Common\Navigation\IndexController@contribute');
Route::middleware('suggest:1,1')->post('/navigation/contribute/hand', '\App\Http\Controllers\Common\Navigation\IndexController@handSuggest');
Route::get('/navigation/stat', '\App\Http\Controllers\Common\Navigation\IndexController@getStat');
Route::post('/navigation/stat', '\App\Http\Controllers\Common\Navigation\IndexController@stat');
Route::get('/navigation/search', '\App\Http\Controllers\Common\Navigation\IndexController@search');
Route::get('/navigation/detail', '\App\Http\Controllers\Common\Navigation\IndexController@detail');
Route::get('/navigation/tag', '\App\Http\Controllers\Common\Navigation\IndexController@tag');
Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config) {
    return $captcha->src($config);
});
