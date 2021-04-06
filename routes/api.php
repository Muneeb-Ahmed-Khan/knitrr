<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/user', function (Request $request) {
        return response()->json($request->user(), 200);
    });


    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'message' => "Welcome to Dashboard"
        ], 200);
    })->name('dashboard');

});

require __DIR__.'/auth.php';
