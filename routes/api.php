<?php

use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\GetCategorySubcategoriesController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['setlang']], function ($router) {

  Route::get('get-categories', GetCategoryController::class);
 
  Route::get('search',SearchController::class);


});
