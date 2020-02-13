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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@aboutMe');
Route::get('/add-supplier','HomeController@addSupplier');
Route::get('/view-suppliers','HomeController@viewSuppliers');
Route::get('/supplier/{sid}','HomeController@supplierDetails');

Route::get('/view-categories','HomeController@viewCategories');
Route::get('/add-category','HomeController@addCategory');
Route::get('/delete-category/{catid}','HomeController@deleteCategory');

Route::get('/add-client','HomeController@addClient');
Route::get('/view-clients','HomeController@viewClients');
Route::get('/client-details/{clid}','HomeController@clientDetails');

Route::get('/add-salesrep','HomeController@addSalesRep');
Route::get('/sales-rep/{srid}','HomeController@salesRepDetails');
Route::get('/view-salesreps','HomeController@viewSalesReps');

Route::get('/add-product','HomeController@addProduct');
Route::get('/view-products','HomeController@viewProducts');
Route::get('/product/{pid}','HomeController@productDetails');

Route::get('/add-sale','HomeController@addSale');
Route::get('/sale-details/{salid}','HomeController@saleDetails');
Route::get('/return-sale','HomeController@returnSale');
Route::get('/return-sale/{salid}','HomeController@returnSaleDetails');
Route::get('/view-sales','HomeController@viewSales');


Route::get('/settings','HomeController@viewSettings');


// invoice and receipts

Route::get('/create-invoice','HomeController@createInvoice');
Route::get('/create-receipt','HomeController@createReceipt');
Route::get('/select-invoice','HomeController@selectInvoice');

Route::get('/view-invoices','HomeController@viewInvoices');
Route::get('/view-receipts','HomeController@viewReceipts');

Route::get('/invoice-details/{invid}','HomeController@invoiceDetails');
Route::get('/client-details/{clid}','HomeController@clientDetails');

Route::get('/invoice/{invid}','HomeController@invoicePDF');
Route::get('/invoices/{invid}','HomeController@invoice');
Route::get('/invoice-details/{invid}','HomeController@invoiceDetails');
Route::get('/receipts/{recid}','HomeController@receipt');
Route::get('/receipt/{recid}','HomeController@receiptPDF');

//expenses
Route::get('/view-expenses','HomeController@viewExpenses');
Route::get('/create-expense', 'HomeController@getCreateExpense');
Route::get('/schedule', 'HomeController@viewSchedule');
Route::get('/view/{exid}', 'HomeController@expenseDetails');


Route::get('/export','HomeController@export');


Route::post('/import','HomeController@import');
Route::post('/create-expense', 'HomeController@postCreateExpense');
Route::post('/create-dept', 'HomeController@postCreateDept');
Route::post('/add-client','HomeController@postAddClient');
Route::post('/add-product','HomeController@postAddProduct');
Route::post('/update-product','HomeController@postUpdateProduct');
Route::post('add-stock','HomeController@postAddStock');
Route::post('/add-supplier','HomeController@postAddSupplier');
Route::post('/add-category','HomeController@postAddCategory');
Route::post('/add-salesrep','HomeController@postAddSalesRep');
Route::post('/return-sale','HomeController@postReturnSale');
Route::post('/add-sale','HomeController@postAddSale');
Route::post('/settings','HomeController@postSettings');
Route::post('/create-invoice','HomeController@postCreateInvoice');
Route::post('/create-receipt','HomeController@postCreateReceipt');
