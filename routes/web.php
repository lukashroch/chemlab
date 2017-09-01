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

// Artisan helpers to bypass missing SSH access on web hosting
Route::group(['prefix' => 'artisan/', 'middleware' => ['role:admin']], function () {
    Route::get('optimize', function () {
        Artisan::call('optimize');
    });

    Route::get('cache-config', function () {
        Artisan::call('config:cache');
    });

    Route::get('cache-route', function () {
        Artisan::call('route:cache');
    });

    Route::get('cache-clear', function () {
        Artisan::call('cache:clear');
    });

    Route::get('view-clear', function () {
        Artisan::call('view:clear');
    });
});

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('credits', ['as' => 'credits', 'uses' => 'HomeController@credits']);
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@home']);

// Profile routes
Route::get('profile', ['as' => 'profile.index', 'uses' => 'ProfileController@index']);
Route::patch('profile/update', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::get('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
Route::patch('profile/password', 'ProfileController@passwordUpdate');

// Admin routes
Route::group(['prefix' => 'admin/'], function () {
    Route::get('', ['as' => 'admin.index', 'uses' => 'AdminController@overview']);
    Route::get('overview', ['as' => 'admin.overview', 'uses' => 'AdminController@overview']);
    Route::get('dbbackup', ['as' => 'admin.dbbackup', 'uses' => 'AdminController@DBBackup']);
    Route::get('dbbackup/create', ['as' => 'admin.dbbackup.create', 'uses' => 'AdminController@DBBackupCreate']);
    Route::get('dbbackup/run', ['as' => 'admin.dbbackup.run', 'uses' => 'AdminController@runBackup']);
    Route::get('dbbackup/show/{name}', ['as' => 'admin.dbbackup.show', 'uses' => 'AdminController@DBBackupShow']);
    Route::delete('dbbackup/delete/{name}', ['as' => 'admin.dbbackup.delete', 'uses' => 'AdminController@DBBackupDelete']);
    Route::get('cache', ['as' => 'admin.cache', 'uses' => 'AdminController@cache']);
    Route::get('cache/clear', ['as' => 'admin.cache.clear', 'uses' => 'AdminController@cacheClear']);
});

// Resource Conttroller - common methods
Route::get('resource/autocomplete', ['uses' => 'ResourceController@autocomplete']);

// Permission Controller
Route::delete('permission/{permission?}', ['as' => 'permission.delete', 'uses' => 'PermissionController@destroy']);
Route::resource('permission', 'PermissionController', ['except' => ['destroy']]);

// Role Controller
Route::patch('role/{role}/permission/{permission}/attach', ['as' => 'role.permission.attach', 'uses' => 'RoleController@attachPermission']);
Route::patch('role/{role}/permission/{permission}/detach', ['as' => 'role.permission.detach', 'uses' => 'RoleController@detachPermission']);
Route::patch('role/{role}/store/{store}/attach', ['as' => 'role.store.attach', 'uses' => 'RoleController@attachStore']);
Route::patch('role/{role}/store/{store}/detach', ['as' => 'role.store.detach', 'uses' => 'RoleController@detachStore']);
Route::delete('role/{role?}', ['as' => 'role.delete', 'uses' => 'RoleController@destroy']);
Route::resource('role', 'RoleController', ['except' => ['destroy']]);

// User Controller
Route::patch('user/{user}/role/{role}/attach', ['as' => 'user.role.attach', 'uses' => 'UserController@attachRole']);
Route::patch('user/{user}/role/{role}detach', ['as' => 'user.role.detach', 'uses' => 'UserController@detachRole']);
Route::delete('user/{user?}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
Route::resource('user', 'UserController', ['except' => ['destroy']]);

// Brand Controller
Route::delete('brand/{brand?}', ['as' => 'brand.delete', 'uses' => 'BrandController@destroy']);
Route::resource('brand', 'BrandController', ['except' => ['destroy']]);

// Store Controller
Route::resource('store', 'StoreController', ['names' => ['destroy' => 'store.delete']]);

// Chemical Controller
Route::get('chemical/test', ['middleware' => ['role:admin'], 'uses' => 'ChemicalController@test']);
Route::get('chemical/test2', ['middleware' => ['role:admin'], 'uses' => 'ChemicalController@test2']);
Route::get('chemical/{chemical}/get-sds', ['as' => 'chemical.get-sds', 'uses' => 'ChemicalController@getSDS']);
Route::group(['prefix' => 'chemical/ajax/'], function () {
    Route::get('check-brand', ['as' => 'chemical.check-brand', 'uses' => 'ChemicalController@checkBrand']);
    Route::get('parse', 'ChemicalController@parse');
});
Route::delete('chemical/{chemical?}', ['as' => 'chemical.delete', 'uses' => 'ChemicalController@destroy']);
Route::resource('chemical', 'ChemicalController', ['except' => ['destroy']]);

// ChemicalItem Controller
Route::patch('chemical-item/move', ['as' => 'chemical-item.move', 'uses' => 'ChemicalItemController@move']);
Route::delete('chemical-item/{item?}', ['as' => 'chemical-item.delete', 'uses' => 'ChemicalItemController@destroy']);
Route::resource('chemical-item', 'ChemicalItemController', [
    'only' => ['store', 'update'],
    'parameters' => ['chemical-item' => 'item']
]);

// NMR Controller
Route::get('nmr/test', ['as' => 'nmr.test', 'uses' => 'NmrController@show']);
Route::get('nmr/{nmr}/download', ['as' => 'nmr.download', 'uses' => 'NmrController@download']);
Route::delete('nmr/{nmr?}', ['as' => 'nmr.delete', 'uses' => 'NmrController@destroy']);
Route::resource('nmr', 'NmrController', ['only' => ['index', 'create', 'store']]);

// Compound Controller
Route::delete('compound/{compound?}', ['as' => 'compound.delete', 'uses' => 'CompoundController@destroy']);
Route::resource('compound', 'CompoundController', ['except' => ['destroy']]);
