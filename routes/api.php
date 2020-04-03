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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Ingredients
Route::get('ingredients/{id}', 'IngredientController@show');
//Route::get('/', 'IngredientController@show');
Route::post('ingredients', 'IngredientController@store');
Route::get('ingredients', 'IngredientController@all');

//Recipes
Route::get('recipes/{id}', 'RecipeController@show');
Route::post('recipes', 'RecipeController@store');
Route::get('recipes', 'RecipeController@all');

//Customer box orders
Route::get('orders/{date}', 'CustomerBoxController@showByDate');
Route::post('orders', 'CustomerBoxController@store');
Route::get('orders', 'CustomerBoxController@all');
