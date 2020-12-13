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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {    
    return $request->user();
});
*/


Route::post('/login', "LoginController@index");

Route::get('/importations', 'ImportationsController@all');
Route::get('/importations/{id}', 'ImportationsController@show');

// Security
//Route::middleware('auth:sanctum')->get('/people', 'PeopleController@all');
//Route::middleware('auth:sanctum')->get('/people/{id}', 'PeopleController@show');
//Route::middleware('auth:sanctum')->get('/shiporders', 'ShipordersController@all');
//Route::middleware('auth:sanctum')->get('/shiporders/{id}', 'ShipordersController@show');

Route::get('/user', 'UserController@all');
Route::get('/user/{id}', 'UserController@show');
Route::post('/user', 'UserController@create');

Route::get('/people', 'PeopleController@all');
Route::get('/people/{id}', 'PeopleController@show');

Route::get('/shiporders', 'ShipordersController@all');
Route::get('/shiporders/{id}', 'ShipordersController@show');