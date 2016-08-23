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

Route::pattern('chemical', '[0-9]+');

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('credits', ['as' => 'credits', 'uses' => 'HomeController@credits']);
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@home']);

Route::group(['prefix' => 'admin/', 'middleware' => ['role:admin']], function () {
    Route::get('', ['as' => 'admin.index', 'uses' => 'AdminController@overview']);
    Route::get('overview', ['as' => 'admin.overview', 'uses' => 'AdminController@overview']);
    Route::get('dbbackup', ['as' => 'admin.dbbackup', 'uses' => 'AdminController@DBBackup']);
    Route::get('dbbackup/create', ['as' => 'admin.dbbackup.create', 'uses' => 'AdminController@DBBackupCreate']);
    Route::get('dbbackup/show/{name}', ['as' => 'admin.dbbackup.show', 'uses' => 'AdminController@DBBackupShow']);
    Route::delete('dbbackup/delete/{name}', ['as' => 'admin.dbbackup.delete', 'uses' => 'AdminController@DBBackupDelete']);
    Route::get('cache', ['as' => 'admin.cache', 'uses' => 'AdminController@cache']);
    Route::get('cache/clear', ['as' => 'admin.cache.clear', 'uses' => 'AdminController@cacheClear']);
});

Route::resource('permission', 'PermissionController', ['names' => ['destroy' => 'permission.delete']]);

Route::resource('role', 'RoleController', ['names' => ['destroy' => 'role.delete']]);

Route::get('user/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile']);
Route::get('user/password', ['as' => 'user.password', 'uses' => 'UserController@password']);
Route::patch('user/password', 'UserController@passwordUpdate');
Route::resource('user', 'UserController', ['names' => ['destroy' => 'user.delete']]);

Route::resource('brand', 'BrandController', ['names' => ['destroy' => 'brand.delete']]);

Route::resource('department', 'DepartmentController', ['names' => ['destroy' => 'department.delete']]);

Route::resource('store', 'StoreController', ['names' => ['destroy' => 'store.delete']]);

//Route::get('chemical/updatesdf', ['as' => 'chemical.updatesdf', 'uses' => 'ChemicalController@updatesdf']);
//Route::get('chemical/msds', ['as' => 'chemical.updatesdf', 'uses' => 'ChemicalController@getMsdsFile']);
Route::get('chemical/stores/{store}', ['as' => 'chemical.stores', 'uses' => 'ChemicalController@stores']);
Route::get('chemical/recent', ['as' => 'chemical.recent', 'uses' => 'ChemicalController@recent']);
Route::get('chemical/search', ['as' => 'chemical.search', 'uses' => 'ChemicalController@search']);
Route::get('chemical/export/{type}/{store?}', ['as' => 'chemical.export', 'uses' => 'ChemicalController@export']);
Route::group(['prefix' => 'chemical/item/', 'middleware' => ['ajax']], function () {
    Route::post('', ['uses' => 'ChemicalController@itemStore']);
    Route::patch('{item}', ['uses' => 'ChemicalController@itemUpdate']);
    Route::delete('{item}', ['uses' => 'ChemicalController@itemDestroy']);
});
Route::resource('chemical', 'ChemicalController', ['names' => ['destroy' => 'chemical.delete']]);

Route::resource('compound', 'CompoundController', ['names' => ['destroy' => 'compound.delete']]);

Route::group(['prefix' => 'ajax/', 'middleware' => ['ajax']], function () {
    Route::group(['prefix' => 'role/', 'middleware' => ['permission:user-edit']], function () {
        Route::get('attach', 'AjaxController@attachRole');
        Route::get('detach', 'AjaxController@detachRole');
    });
    Route::group(['prefix' => 'perm/', 'middleware' => ['permission:role-edit']], function () {
        Route::get('attach', 'AjaxController@attachPermission');
        Route::get('detach', 'AjaxController@detachPermission');
    });

    Route::post('user/settings', 'AjaxController@userSettings');
    Route::get('sdf', 'AjaxController@sdf');
    Route::get('brand', 'AjaxController@checkBrand');
    Route::get('sigma', 'AjaxController@parseSAData');
    Route::get('autocomplete', 'AjaxController@fillAutoComplete');
    Route::get('trans', 'AjaxController@translate');
});
