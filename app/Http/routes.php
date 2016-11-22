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

  Route::get('/', 'DashboardController@welcome');

  Route::auth();
});

Route::group(['middleware' => ['web','auth']], function () {
    //Basic routes
    Route::get('/home', 'HomeController@index');

    Route::get('shippment', function () {
        return view('shippment.index');
    });
    Route::resource('customer', 'CustomerController');

    Route::resource('inventory', 'InventoryController');

    Route::resource('supplier', 'SupplierController');

    Route::resource('employee', 'EmployeeController');

    Route::resource('purchase', 'ManagePurchaseController');

    Route::resource('mycompany', 'MyCompanyController');

    Route::resource('annual_report', 'AnnualReportController');

    Route::resource('shippment/proforma', 'ProformaInvoiceController');

    Route::resource('shippment/commercial', 'CommercialInvoiceController');

    Route::resource('setKits','setKitsController');
    //Editing Images
    //new version
    Route::get('myImage/','ImageController@myImage');

    Route::post('addImage/inventory','ImageController@addInvImage');

    Route::post('addImage/mycompany','ImageController@addComImage');

    Route::get('deleteImage/inventory/{id}','ImageController@deleteInvImage');

    //old version
    //Route::post('addImage/{resource}/{item}/{item_id}','ImageController@addImage');

    Route::get('viewImage/{id}/{item_id}','ImageController@viewImage');

    Route::get('deleteImage/{id}/{item_id}','ImageController@deleteImage');
    //Managing Information Export
    Route::get('information','InformationController@InformationIndex');

    Route::post('information/{type}','InformationController@InformationExport');
    //Converts the proforma records to shipping records
    Route::get('convert/{id}','DashboardController@convert');
    //Excel and PDF
    //excel
    Route::post('excel','ExcelController@exportExcel');
    //invoices excel outputs
    Route::post('excel_invoice','ExcelController@exportExcel_invoice');
    //
    Route::get('excel/{invoice}/{id}','ExcelController@exportExcel_record');

    //pdf
    Route::post('pdf','ExcelController@exportPDF');

    Route::get('test','DashboardController@test');
});
