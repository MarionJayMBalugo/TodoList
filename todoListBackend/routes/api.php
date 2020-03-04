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
//List todos
Route::get('todos/{user_id}','TodoController@index');

//List single todo
Route::get('todos/{id}','TodoController@show');

//Create new todo
Route::post('todo','TodoController@store');

//Update todo
Route::put('todo','TodoController@store');

//Delete todo
Route::delete('todo/{id}','TodoController@destroy');

//List searched todo
Route::get('todo/search/{searchName}','TodoController@search');

Route::get('todo/search/Done/{user_id}','TodoController@searchAllDone');

Route::get('todo/search/NotYet/{user_id}','TodoController@searchAllNotYet');