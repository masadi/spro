<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::get('profile', 'API\V1\ProfileController@profile');
Route::put('profile', 'API\V1\ProfileController@updateProfile');
Route::post('change-password', 'API\V1\ProfileController@changePassword');
Route::get('tag/list', 'API\V1\TagController@list');
Route::get('category/list', 'API\V1\CategoryController@list');
Route::post('product/upload', 'API\V1\ProductController@upload');
Route::get('get-sub-ib', 'SubibController@list');
Route::apiResources([
    'user' => 'API\V1\UserController',
    'product' => 'API\V1\ProductController',
    'category' => 'API\V1\CategoryController',
    'tag' => 'API\V1\TagController',
    'sub-ib' => 'SubibController',
    'trader' => 'TraderController',
    'dollar' => 'DollarController',
]);
Route::prefix('master')->group(function () {
    Route::get('/trader', 'TraderController@new_trader');
});
Route::prefix('transaksi')->group(function () {
    Route::get('/upload', 'TransaksiController@upload');
    Route::post('/upload-file', 'TransaksiController@upload_file');
    Route::get('/rebate', 'TransaksiController@rebate');
    Route::get('/komisi', 'TransaksiController@komisi');
    Route::get('/trader', 'TransaksiController@trader');
    //Route::post('/all-kelas', 'TransaksiController@all_kelas');
    //Route::post('select-kelas', 'TransaksiController@select_kelas');
    //Route::post('simpan-wali-kelas', 'TransaksiController@simpan_wali_kelas');
});
