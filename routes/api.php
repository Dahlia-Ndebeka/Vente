<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productsController;
use App\Http\Controllers\categoriesController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes concernant les produits

Route::post('create-image/{id}', [productsController::class, 'createImage']);
Route::post('create-product', [productsController::class, 'createProduct']);
Route::put("put-product/{id}", [productsController::class, 'putProduct']);
Route::delete("delete-product", [productsController::class, 'deleteProduct']);
Route::get('image-product/{filename}', [productsController::class, 'image']);
Route::get('get-product/{id}', [productsController::class, 'getProduit']);
Route::get('get-products', [productsController::class, 'getProducts']);


// Routes concernant les categories

Route::post('create-category', [categoriesController::class, 'createCategory']);
Route::put("put-category/{id}", [categoriesController::class, 'putCategory']);
Route::delete("delete-category", [categoriesController::class, 'deleteCategory']);
Route::get('get-category/{id}', [categoriesController::class, 'createCategory']);
Route::get('get-categories', [categoriesController::class, 'getCategories']);

