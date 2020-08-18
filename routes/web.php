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

// Route::get('/', function () {
//     return view('welcome');
// });
//給前端傳遞參數的方法
// Route::get('/', function () {
//     return view('welcome', ['name' => 'UserName']);
// });

// Route::get('/', function () {
//     return view('mainlayout.index', ['name' => 'AAAA']);
// });


Route::get('/', function () {
    return view('mainlayout.layouts.index');
})->name('home');
Route::get('/ShowVideo', function () {
    return view('ShowVideo.ShowVideo');
})->name('ShowVideo');


/********* ShowData ***********/
//資料呈現
//Route::get('/ShowData/{system}', 'ShowAll@ShowAll');
Route::get('/ShowData/{system}', 'ShowAll@ShowAll');

/*************************** Sampling Records *****************************/
Route::get('/SamplingRecord/show', 'SamplingRecordController@show');
Route::post('/SamplingRecord/export', 'SamplingRecordController@export');
Route::get('/SamplingRecord/showOperLog', 'SamplingRecordController@showOperLog');
Route::post('/SamplingRecord/GetDataFromID', 'SamplingRecordController@GetDataFromID');

//資料呈現
Route::get('/SamplingRecord', 'SamplingRecordController@index');
Route::get('/SamplingRecord/GetComboboxItem', 'SamplingRecordController@ComboboxItem');
Route::get('/SamplingRecord/GetproductSPEC', 'SamplingRecordController@GetproductSPEC');
Route::get('SamplingRecord/GetAuthority', 'SamplingRecordController@GetAuthority');
Route::get('SamplingRecord/GetUserName', 'SamplingRecordController@GetUserName');

//TEST
Route::get('/SamplingRecordTest', 'SamplingRecordController@test');

//File 大量新增和修改
Route::post('/SamplingRecord/FileUpload/{todo}', 'SamplingRecordController@FileUpload')->name('SamplingRecord.FileUpload');

//Grid inline 新增和修改
Route::any('/SamplingRecord/AddandUpdate/{todo}', 'SamplingRecordController@AddandUpdate')->name('SamplingRecord.AddandUpdate');

//Grid 刪除
Route::any('/SamplingRecord/delete/{todo}', 'SamplingRecordController@destroy')->name('SamplingRecord.destroy');


/*************************** SolventRemoval *****************************/
Route::get('/SolventRemoval/show', 'Solvent_removal_Controller@show');
Route::post('/SolventRemoval/export', 'Solvent_removal_Controller@export');
//資料呈現
Route::get('/SolventRemoval', 'Solvent_removal_Controller@index');
Route::get('/SolventRemoval/GetComboboxItem', 'Solvent_removal_Controller@ComboboxItem');

//File 大量新增和修改
Route::post('/SolventRemoval/FileUpload/{todo}', 'Solvent_removal_Controller@FileUpload')->name('Solvent_removal.FileUpload');

//Grid inline 新增和修改
Route::any('/SolventRemoval/AddandUpdate/{todo}', 'Solvent_removal_Controller@AddandUpdate')->name('Solvent_removal.AddandUpdate');

//Grid 刪除
Route::delete('/SolventRemoval/delete/{todo}', 'Solvent_removal_Controller@destroy')->name('Solvent_removal.destroy');

//Grid 回填
Route::post('/SolventRemoval/BackFill/{todo}', 'Solvent_removal_Controller@BackFill')->name('Solvent_removal.BackFill');


/*************************** Sublimation *****************************/
Route::get('/Sublimation/show', 'SublimationController@show');
Route::post('/Sublimation/export', 'SublimationController@export');
//資料呈現
Route::get('/Sublimation', 'SublimationController@index');
Route::get('/Sublimation/GetComboboxItem', 'SublimationController@ComboboxItem');

//File 大量新增和修改
Route::post('/Sublimation/FileUpload/{todo}', 'SublimationController@FileUpload')->name('Sublimation.FileUpload');

//Grid inline 新增和修改
Route::any('/Sublimation/AddandUpdate/{todo}', 'SublimationController@AddandUpdate')->name('Sublimation.AddandUpdate');

//Grid 刪除
Route::delete('/Sublimation/delete/{todo}', 'SublimationController@destroy')->name('Sublimation.destroy');

//Grid 回填
Route::post('/Sublimation/BackFill/{todo}', 'SublimationController@BackFill')->name('Sublimation.BackFill');


/*************************** GrindingOven *****************************/
Route::get('/GrindingOven/show', 'GrindingOvenController@show');
Route::post('/GrindingOven/export', 'GrindingOvenController@export');

//資料呈現
Route::get('/GrindingOven', 'GrindingOvenController@index');
Route::get('/GrindingOven/GetComboboxItem', 'GrindingOvenController@ComboboxItem');

//File 大量新增和修改
Route::post('/GrindingOven/FileUpload/{todo}', 'GrindingOvenController@FileUpload')->name('GrindingOven.FileUpload');

//Grid inline 新增和修改
Route::any('/GrindingOven/AddandUpdate/{todo}', 'GrindingOvenController@AddandUpdate')->name('GrindingOven.AddandUpdate');

//Grid 刪除
Route::delete('/GrindingOven/delete/{todo}', 'GrindingOvenController@destroy')->name('GrindingOven.destroy');

//Grid 回填
Route::post('/GrindingOven/BackFill/{todo}', 'GrindingOvenController@BackFill')->name('GrindingOven.BackFill');


/*************************** ProductSPEC *****************************/
//資料呈現
Route::get('/ProductSPEC', 'ProductSPECController@index');
Route::get('/ProductSPEC/show/{todo}', 'ProductSPECController@show');
Route::post('/ProductSPEC/export', 'ProductSPECController@export');
Route::get('/ProductSPEC/GetTable/{todo}', 'ProductSPECController@GetTable');

//File 大量新增和修改
Route::post('/ProductSPEC/FileUpload/{todo}', 'ProductSPECController@FileUpload')->name('ProductSPEC.FileUpload');

//Grid inline 新增和修改
Route::any('/ProductSPEC/AddandUpdate/{todo}', 'ProductSPECController@AddandUpdate')->name('ProductSPEC.AddandUpdate');

//Grid 刪除
Route::delete('/ProductSPEC/delete/{todo}', 'ProductSPECController@destroy')->name('ProductSPEC.destroy');


/*************************** Authority *****************************/
//資料呈現
Route::get('/Authority', 'AuthorityController@index');
Route::get('/Authority/show/{todo}', 'AuthorityController@show');
Route::post('/Authority/export', 'AuthorityController@export');
Route::get('/Authority/GetAuthorityGroup', 'AuthorityController@GetAuthorityGroup');


//File 大量新增和修改
Route::post('/Authority/FileUpload/{todo}', 'AuthorityController@FileUpload')->name('Authority.FileUpload');

//Grid inline 新增和修改
Route::any('/Authority/AddandUpdate/{todo}', 'AuthorityController@AddandUpdate')->name('Authority.AddandUpdate');

//Grid 刪除
Route::delete('/Authority/delete/{todo}', 'AuthorityController@destroy')->name('Authority.destroy');




/********* Todo ***********/
//資料呈現
Route::get('/todo', 'TodoController@index');
Route::get('/todo/GetComboboxItem', 'TodoController@ComboboxItem');

//File 大量新增和修改
Route::post('/todo/FileUpload/{todo}', 'TodoController@FileUpload')->name('todo.FileUpload');

//Grid inline 新增和修改
Route::any('/todo/AddandUpdate/{todo}', 'TodoController@AddandUpdate')->name('todo.AddandUpdate');
//Grid 刪除
Route::delete('/todo/delete/{todo}', 'TodoController@destroy')->name('todo.destroy');


Route::get('/todo/test', 'TodoController@test');
Route::get('/Chart1', function () {
    return view('todo.Chart1');
})->name('Chart1');
Route::get('/Chart2', function () {
    return view('todo.Chart2');
})->name('Chart2');

