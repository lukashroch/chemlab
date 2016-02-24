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

Route::pattern('id', '[0-9]+');

Route::group(['middleware' => ['web']], function () {
    Route::auth();

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
        Route::get('cache/update', ['as' => 'admin.cache.update', 'uses' => 'AdminController@cacheUpdate']);
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

    Route::get('chemical/updatesdf', ['as' => 'chemical.updatesdf', 'uses' => 'ChemicalController@updatesdf']);
    Route::get('chemical/recent', ['as' => 'chemical.recent', 'uses' => 'ChemicalController@recent']);
    Route::get('chemical/search', ['as' => 'chemical.search', 'uses' => 'ChemicalController@search']);
    Route::get('chemical/search#sketcherPop', ['as' => 'chemical.search.structure', 'uses' => 'ChemicalController@search']);
    Route::get('chemical/export/{type}', ['as' => 'chemical.export', 'uses' => 'ChemicalController@export']);
    Route::resource('chemical', 'ChemicalController', ['names' => ['destroy' => 'chemical.delete']]);

    Route::resource('compound', 'CompoundController', ['names' => ['destroy' => 'compound.delete']]);

    Route::group(['prefix' => 'ajax/'], function () {
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
        Route::get('chemical-item', 'AjaxController@chemicalItem');
        Route::get('brand', 'AjaxController@checkBrand');
        Route::get('storelist', 'AjaxController@updateStoreList');
        Route::get('sigma', 'AjaxController@parseSAData');
        Route::get('autocomplete', 'AjaxController@fillAutoComplete');
        Route::get('trans', 'AjaxController@translate');
    });
});

