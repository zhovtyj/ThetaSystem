<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//STATIC PAGES
Route::get('/', 'PagesController@getIndex');

//AUTH PAGES
Auth::routes();

//ADMIN ROUTES
Route::get('/settings/',[
    'uses' => 'SettingsController@getIndex',
    'as' => 'settings',
    'middleware' => 'roles',
    'roles' => ['admin']
]);
Route::post('/settings/',[
    'uses' => 'SettingsController@saveUser',
    'as' => 'save.user',
    'middleware' => 'roles',
    'roles' => ['admin']
]);
Route::post('/settings/importcsv',[
    'uses' => 'SettingsController@importCsv',
    'as' => 'import.csv',
    'middleware' => 'roles',
    'roles' => ['admin']
]);
/*Route::post('/settings/exportcsv',[
    'uses' => 'SettingsController@exportCsv',
    'as' => 'export.csv',
    'middleware' => 'roles',
    'roles' => ['admin']
]);*/
Route::get('/report/',[
    'uses' => 'ReportsController@getIndex',
    'as' => 'report',
    'middleware' => 'roles',
    'roles' => ['admin']
]);
Route::post('/report/',[
    'uses' => 'ReportsController@changeStatus',
    'as' => 'change.status',
    'middleware' => 'roles',
    'roles' => ['admin']
]);

//AGENT ROUTES
Route::get('/entries/{link}',[
    'uses' => 'EntriesController@getIndex',
    'as' => 'entries',
    'middleware' => 'roles',
    'roles' => ['agent']
]);
Route::put('/entries/{link}/update',[
    'uses' => 'EntriesController@update',
    'as' => 'status.update',
    'middleware' => 'roles',
    'roles' => ['agent']
]);




