<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::auth();

    Route::resource('customer', 'CustomerController');

    Route::resource('inventory', 'InventoryController');

    Route::resource('supplier', 'SupplierController');

    Route::resource('purchase', 'ManagePurchaseController');

    Route::resource('mycompany', 'MyCompanyController');

    Route::resource('shippment/proforma', 'ProformaInvoiceController');

    Route::resource('shippment/commercial', 'CommercialInvoiceController');

    Route::post('addImage/{resource}/{item}/{item_id}','ImageController@addImage');

    Route::get('viewImage/{id}/{item_id}','ImageController@viewImage');

    Route::get('deleteImage/{id}/{item_id}','ImageController@deleteImage');

    Route::get('shippment', function () {
        return view('shippment.index');
    });
    Route::get('/home', 'HomeController@index');
});
