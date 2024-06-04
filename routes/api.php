<?php

use App\Http\Controllers\API\CategorySubcategoryController;
use App\Http\Controllers\API\GetCordinateController;
use App\Http\Controllers\API\NearestBranchesController;
use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\GetCategorySubcategoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchedAddressController;
use App\Models\CategorySubcategory;
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
// 
  Route::post('categories-organizations',CategorySubcategoryController::class);
  Route::post('nearest-branches',NearestBranchesController::class);

  Route::get('searched-address',[SearchedAddressController::class,'index']);

  Route::get('coordinates',GetCordinateController::class);


});
