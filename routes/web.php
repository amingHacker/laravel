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

//寄Mail
Route::any('/AbnormalEventMail', 'AbnormalEventMailController@send');

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


/*************************** Sampling Records My Chart *****************************/
//資料呈現
Route::get('/MyCharts', 'SamplingRecordController@MyCharts');
Route::get('/MyCharts/show', 'SamplingRecordController@MyChartsShow');
Route::get('/MyCharts/GetMyChartCondition', 'SamplingRecordController@GetMyChartCondition');

//儲存MyChart的設定
Route::any('/MyCharts/SaveMyChartCondition', 'SamplingRecordController@SaveMyChartCondition');

//重置MyChart的設定
Route::any('/MyCharts/ResetMyChartCondition', 'SamplingRecordController@ResetMyChartCondition');

//根據搜尋條件輸出資料 
Route::post('/MyCharts/MyChartExport', 'SamplingRecordController@MyChartExport');


/*************************** SolventRemoval *****************************/
Route::get('/SolventRemoval/show', 'Solvent_removal_Controller@show');
Route::post('/SolventRemoval/export', 'Solvent_removal_Controller@export');
Route::post('/SolventRemoval/GetDataFromID', 'Solvent_removal_Controller@GetDataFromID');

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
Route::post('/Sublimation/GetDataFromID', 'SublimationController@GetDataFromID');

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
Route::post('/GrindingOven/GetDataFromID', 'GrindingOvenController@GetDataFromID');

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


/*************************** AbnormalEvent *****************************/
//資料呈現

Route::get('/AbnormalEvent', 'AbnormalEventController@index');
Route::get('/AbnormalEvent/show/{todo}', 'AbnormalEventController@show');
Route::post('/AbnormalEvent/export', 'AbnormalEventController@export');
Route::get('/AbnormalEvent/GetTable/{todo}', 'AbnormalEventController@GetTable');
Route::get('/AbnormalEvent/GetComboboxItem', 'AbnormalEventController@GetComboboxItem');
Route::post('/AbnormalEvent/GetDataFromID', 'AbnormalEventController@GetDataFromID');


//File 大量新增和修改
Route::post('/AbnormalEvent/FileUpload/{todo}', 'AbnormalEventController@FileUpload')->name('AbnormalEvent.FileUpload');

//Grid inline 新增和修改
Route::any('/AbnormalEvent/AddandUpdate/{todo}', 'AbnormalEventController@AddandUpdate')->name('AbnormalEvent.AddandUpdate');

//Grid 刪除
Route::delete('/AbnormalEvent/delete/{todo}', 'AbnormalEventController@destroy')->name('AbnormalEvent.destroy');


/*************************** Container Golden Sample *****************************/
Route::get('/Container_GdSp/show', 'Container_GdSp_Controller@show');
Route::post('/Container_GdSp/export', 'Container_GdSp_Controller@export');
Route::post('/Container_GdSp/GetDataFromID', 'Container_GdSp_Controller@GetDataFromID');

//資料呈現
Route::get('/Container_GdSp', 'Container_GdSp_Controller@index');
Route::get('/Container_GdSp/GetComboboxItem', 'Container_GdSp_Controller@ComboboxItem');
Route::get('SamplingRecord/GetAuthority', 'SamplingRecordController@GetAuthority');
Route::get('SamplingRecord/GetUserName', 'SamplingRecordController@GetUserName');

//File 大量新增和修改
Route::post('/Container_GdSp/FileUpload/{todo}', 'Container_GdSp_Controller@FileUpload')->name('Container_GdSp.FileUpload');

//Grid inline 新增和修改
Route::any('/Container_GdSp/AddandUpdate/{todo}', 'Container_GdSp_Controller@AddandUpdate')->name('Container_GdSp.AddandUpdate');

//Grid 刪除
Route::any('/Container_GdSp/delete/{todo}', 'Container_GdSp_Controller@destroy')->name('Container_GdSp.destroy');

/*************************** ContainerRecord *****************************/
//資料呈現
Route::get('/ContainerRecord', 'ContainerRecordController@index');
Route::get('/ContainerRecord/show/{todo}', 'ContainerRecordController@show');
Route::post('/ContainerRecord/export', 'ContainerRecordController@export');
Route::get('/ContainerRecord/GetTable/{todo}', 'ContainerRecordController@GetTable');
Route::get('/ContainerRecord/GetComboboxItem', 'ContainerRecordController@ComboboxItem');
Route::post('/ContainerRecord/GetDataFromID/{todo}', 'ContainerRecordController@GetDataFromID');

//File 大量新增和修改
Route::post('/ContainerRecord/FileUpload/{todo}', 'ContainerRecordController@FileUpload')->name('ContainerRecord.FileUpload');

//Grid inline 新增和修改
Route::any('/ContainerRecord/AddandUpdate/{todo}', 'ContainerRecordController@AddandUpdate')->name('ContainerRecord.AddandUpdate');

//Grid 刪除
Route::delete('/ContainerRecord/delete/{todo}', 'ContainerRecordController@destroy')->name('ContainerRecord.destroy');

/*************************** ContainerRecord *****************************/
//資料呈現
Route::get('/ContainerSPEC', 'ContainerSPECController@index');
Route::get('/ContainerSPEC/show/{todo}', 'ContainerSPECController@show');
Route::post('/ContainerSPEC/export', 'ContainerSPECController@export');
Route::get('/ContainerSPEC/GetTable/{todo}', 'ContainerSPECController@GetTable');
Route::get('/ContainerSPEC/GetComboboxItem', 'ContainerSPECController@ComboboxItem');
Route::post('/ContainerSPEC/GetDataFromID/{todo}', 'ContainerSPECController@GetDataFromID');

//File 大量新增和修改
Route::post('/ContainerSPEC/FileUpload/{todo}', 'ContainerSPECController@FileUpload')->name('ContainerSPEC.FileUpload');

//Grid inline 新增和修改
Route::any('/ContainerSPEC/AddandUpdate/{todo}', 'ContainerSPECController@AddandUpdate')->name('ContainerSPEC.AddandUpdate');

//Grid 刪除
Route::delete('/ContainerSPEC/delete/{todo}', 'ContainerSPECController@destroy')->name('ContainerSPEC.destroy');

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
Route::get('/Chart3', function () {
    return view('todo.Chart3');
})->name('Chart3');

