<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tems/View', function () {
    return view('Items/view');
});

Route::auth();

Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);
Route::get('/item', ['uses' => 'ItemsController@index', 'as' => 'itemIndex']);

Route::resource('Menus', 'MenusController');
Route::resource('Items', 'ItemsController');
Route::resource('Meals', 'MealsController');
Route::get('/add-to-meal/{id}',[
	'uses' =>'ItemsController@getAddMeal',
	'as' =>'item.addToMeal',
	'middleware'=>'auth'
]);
Route::get('/order-Meal',[
	'uses' =>'ItemsController@getOrder',
	'as' =>'item.orderMeal',
	'middleware'=>'auth'
]);
Route::get('/checkout',[
	'uses' => 'ItemsController@getCheckout',
	'as' => 'checkout',
	'middleware'=>'auth'
]);
Route::post('/checkout',[
	'uses' => 'ItemsController@postCheckout',
	'as' => 'checkout',
	'midlleware'=>'auth'
]);
Route::get('/Items/View/id', 'MenusController@details');
Route::get('/Menus', 'MenusController@index');

//factory(App\OrderUser::class, 100)->create();