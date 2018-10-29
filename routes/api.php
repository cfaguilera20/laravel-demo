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


Route::group(['prefix' => 'books', 'namespace' => 'API'], function () {
    $this->get('/', 'BookController@index')->name('book.index');
    $this->post('/', 'BookController@store')->name('book.store');
    $this->get('/{book}', 'BookController@show')->name('book.show');
    $this->post('/{book}', 'BookController@update')->name('book.update');
    $this->post('/{book}/destroy', 'BookController@destroy')->name('book.destroy');
});
Route::group(['prefix' => 'authors', 'namespace' => 'API'], function () {
    $this->get('/', 'AuthorController@index')->name('author.index');
    $this->post('/', 'AuthorController@store')->name('author.store');
    $this->get('/{author}', 'AuthorController@show')->name('author.show');
    $this->post('/{author}', 'AuthorController@update')->name('author.update');
    $this->post('/{author}/destroy', 'AuthorController@destroy')->name('author.destroy');
});