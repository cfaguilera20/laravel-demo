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
    $this->get('/{book}', 'BookController@show')->name('book.show')->where('book', '[\d]+');
    $this->post('/{book}', 'BookController@update')->name('book.update')->where('book', '[\d]+');
    $this->post('/{book}/destroy', 'BookController@destroy')->name('book.destroy')->where('book', '[\d]+');
});
Route::group(['prefix' => 'authors', 'namespace' => 'API'], function () {
    $this->get('/', 'AuthorController@index')->name('author.index');
    $this->post('/', 'AuthorController@store')->name('author.store');
    $this->get('/{author}', 'AuthorController@show')->name('author.show')->where('author', '[\d]+');
    $this->post('/{author}', 'AuthorController@update')->name('author.update')->where('author', '[\d]+');
    $this->post('/{author}/destroy', 'AuthorController@destroy')->name('author.destroy')->where('author', '[\d]+');


    //Books
    Route::get('/{author}/books', 'AuthorBookController@index')->name('author.book.index')->where('author', '[\d]+');
    Route::post('/{author}/books', 'AuthorBookController@store')->name('author.book.store')->where('author', '[\d]+');
});