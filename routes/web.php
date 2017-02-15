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

// Permission Controller
Route::delete('permission/{permission?}', ['as' => 'permission.delete', 'uses' => 'PermissionController@destroy']);
Route::resource('permission', 'PermissionController', ['except' => ['destroy']]);

// Role Controller
Route::group(['middleware' => ['ajax', 'permission:role-edit']], function () {
    Route::patch('role/{role}/attach/{perm?}', ['as' => 'role.perm.attach', 'uses' => 'RoleController@attachPermission']);
    Route::patch('role/{role}/detach/{perm?}', ['as' => 'role.perm.detach', 'uses' => 'RoleController@detachPermission']);
});
Route::delete('role/{role?}', ['as' => 'role.delete', 'uses' => 'RoleController@destroy']);
Route::resource('role', 'RoleController', ['except' => ['destroy']]);

// User Controller
Route::get('user/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile']);
Route::get('user/password', ['as' => 'user.password', 'uses' => 'UserController@password']);
Route::patch('user/password', 'UserController@passwordUpdate');
Route::group(['middleware' => ['ajax', 'permission:user-edit']], function () {
    Route::patch('user/{user}/attach/{role?}', ['as' => 'user.role.attach', 'uses' => 'UserController@attachRole']);
    Route::patch('user/{user}/detach/{role?}', ['as' => 'user.role.detach', 'uses' => 'UserController@detachRole']);
});
Route::delete('user/{user?}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
Route::resource('user', 'UserController', ['except' => ['destroy']]);

// Brand Controller
Route::delete('brand/{brand?}', ['as' => 'brand.delete', 'uses' => 'BrandController@destroy']);
Route::resource('brand', 'BrandController', ['except' => ['destroy']]);

// Store Controller
Route::resource('store', 'StoreController', ['names' => ['destroy' => 'store.delete']]);

// Chemical Controller
//Route::get('chemical/msds', ['as' => 'chemical.recent', 'uses' => 'ChemicalController@getMsdsFile']);
Route::get('chemical/recent', ['as' => 'chemical.recent', 'uses' => 'ChemicalController@recent']);
Route::get('chemical/export/{type}/{store?}', ['as' => 'chemical.export', 'uses' => 'ChemicalController@export']);
Route::delete('chemical/{chemical?}', ['as' => 'chemical.delete', 'uses' => 'ChemicalController@destroy']);
Route::resource('chemical', 'ChemicalController', ['except' => ['destroy']]);

// ChemicalItem Controller
Route::patch('chemical-item/move', [
    'as' => 'chemical-item.move',
    'uses' => 'ChemicalItemController@move'
]);
Route::delete('chemical-item/{item?}', ['as' => 'chemical-item.delete', 'uses' => 'ChemicalItemController@destroy']);
Route::resource('chemical-item', 'ChemicalItemController', [
    'only' => ['store', 'update'],
    'parameters' => ['chemical-item' => 'item']
]);

// Compound Controller
Route::delete('compound/{compound?}', ['as' => 'compound.delete', 'uses' => 'CompoundController@destroy']);
Route::resource('compound', 'CompoundController', ['except' => ['destroy']]);

// Ajax Controller
Route::group(['prefix' => 'ajax/', 'middleware' => ['ajax']], function () {
    Route::post('user/settings', 'AjaxController@userSettings');
    Route::get('sdf', 'AjaxController@sdf');
    Route::get('brand', 'AjaxController@checkBrand');
    Route::get('sigma', 'AjaxController@parseSAData');
    Route::get('autocomplete', 'AjaxController@fillAutoComplete');
    Route::get('trans', 'AjaxController@translate');
});
