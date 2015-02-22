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


//Route::get('/', 'HomeController@index');
Route::get('/', function(){
    return redirect()->route('customers.index');
});

Route::pattern('customers', '[0-9]+');
Route::resource('customers', 'CustomersController');
Route::get('customers/duplicates', [
    'as' => 'customers.duplicates',
    'uses' => 'CustomersController@listDuplicates'
]);
Route::get('customers/duplicates/{customers}', [
    'as' => 'customers.duplicates.view',
    'uses' => 'CustomersController@viewDuplicateProfile'
]);
Route::post('customers/duplicates/{customers}', [
    'as' => 'customers.profiles.merge',
    'uses' => 'CustomersController@mergeDuplicateProfiles'
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
