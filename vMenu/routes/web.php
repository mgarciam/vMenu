<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MenuController@index')->name('menu');

Route::post('/add-cart', 'MenuController@addToCart')->name('add-cart');

Route::get('/see-cart', 'CartController@index')->name('see-cart');

Route::get('/delete-item', 'CartController@deleteItem')->name('delete-item');

Route::post('/checkout', 'CartController@checkout')->name('checkout');

Auth::routes();

Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});

Route::post('/password/email', function () {
    return view('welcome');
});

Route::get('/password/reset/{token}', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/password/reset', function(){
    return redirect('/');
});

Route::group(['middleware' => ['auth']], function() {
	Route::get('/dashboard', 'DashboardController@show')->name('dashboard');

	//Account settings for users
	
	Route::get('/settings', 'SettingsController@index')->name('settings');

	Route::post('/settings', 'SettingsController@update');

	Route::post('/settings/update', 'SettingsController@updateInfo');

	//Administrative users routes

	Route::get('/admins', 'AdminsController@index')->name('admins');

	Route::get('/add-user', 'AddUserController@index')->name('add-user');

	Route::post('/add-user', 'AddUserController@addUser')->name('add-user');

	Route::post('/admins/delete-user', 'AdminsController@deleteUser')->name('delete-user');

	Route::get('/admins/edit-user', 'AdminsController@editUser')->name('edit-user');

	Route::post('/admins/update-user', 'AdminsController@updateUser')->name('update-user');

	//Rooms routes

	Route::get('/rooms', 'RoomsController@index')->name('rooms');

	Route::get('/add-room', 'AddRoomController@index')->name('add-room');

	Route::post('/add-room', 'AddRoomController@addRoom')->name('add-room');

	Route::get('/rooms/edit-room', 'RoomsController@editRoom')->name('edit-room');

	Route::post('/rooms/update-user', 'RoomsController@updateRoom')->name('update-room');

	Route::post('/rooms/delete-room', 'RoomsController@deleteRoom')->name('delete-room');

	//Guests routes

	Route::get('/guests', 'GuestsController@index')->name('guests');

	Route::get('/add-guest', 'AddGuestController@index')->name('add-guest');

	Route::post('/add-guest', 'AddGuestController@addGuest')->name('add-guest');

	Route::get('/guests/edit-guest', 'GuestsController@editGuest')->name('edit-guest');

	Route::post('/guests/update-guest', 'GuestsController@updateGuest')->name('update-guest');

	Route::post('/guests/delete-guest', 'GuestsController@deleteGuest')->name('delete-guest');

	//Categories routes

	Route::get('/categories', 'CategoriesController@index')->name('categories');

	Route::get('/add-category', 'AddCategoryController@index')->name('add-category');

	Route::post('/add-category', 'AddCategoryController@addCategory')->name('add-category');

	Route::get('/categories/edit-category', 'CategoriesController@editCategory')->name('edit-category');

	Route::post('/categories/update-category', 'CategoriesController@updateCategory')->name('update-category');

	Route::post('/categories/delete-category', 'CategoriesController@deleteCategory')->name('delete-category');

	//Meals routes

	Route::get('/meals', 'MealsController@index')->name('meals');

	Route::get('/add-meal', 'AddMealController@index')->name('add-meal');

	Route::post('/add-meal', 'AddMealController@addMeal')->name('add-meal');

	Route::get('/meals/edit-meal', 'MealsController@editMeal')->name('edit-meal');

	Route::post('/meals/update-meal', 'MealsController@updateMeal')->name('update-meal');

	Route::post('/meals/delete-meal', 'MealsController@deleteMeal')->name('delete-meal');

	//Orders routes

	Route::get('/orders', 'OrdersController@index')->name('orders');

	Route::get('/orders/edit-order', 'OrdersController@editOrder')->name('edit-order');

	Route::post('/orders/update-order', 'OrdersController@updateOrder')->name('update-order');

	Route::post('/orders/delete-order', 'OrdersController@deleteOrder')->name('delete-order');

});
