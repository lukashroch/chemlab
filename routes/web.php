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

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('credits', 'HomeController@credits')->name('credits');

// Profile routes
Route::group(['prefix' => 'profile'], function () {
    Route::get('', 'ProfileController@index')->name('profile.index');
    Route::patch('update', 'ProfileController@update')->name('profile.update');
    Route::get('password', 'ProfileController@password')->name('profile.password');
    Route::patch('password', 'ProfileController@passwordUpdate');
});

// Admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    /**
     * Audits routes
     */
    Route::group(['prefix' => 'audits'], function () {
        Route::post('dt', 'AuditsController@index')->name('audits.dt');
        Route::get('', 'AuditsController@index')->name('audits.index');
        Route::get('{audit}', 'AuditsController@show')->name('audits.show');
    });

    /**
     * Backups routes
     */
    Route::group(['prefix' => 'backups'], function () {
        Route::get('', 'BackupsController@index')->name('backups.index');
        Route::get('cron/{token?}', 'BackupsController@cron')->name('backups.cron');
        Route::get('create', 'BackupsController@create')->name('backups.create');
        Route::get('{backup}', 'BackupsController@download')->name('backups.download');
        Route::delete('{backup}', 'BackupsController@delete')->name('backups.delete');
    });

    /**
     * Cache routes
     */
    Route::group(['prefix' => 'cache'], function () {
        Route::get('', 'CacheController@index')->name('cache.index');
        Route::get('clear/{path}', 'CacheController@clear')->name('cache.clear');
    });

    /**
     * Logs routes
     */
    Route::group(['prefix' => 'logs'], function () {
        Route::get('', 'LogsController@index')->name('logs.index');
        Route::get('{log}', 'LogsController@show')->name('logs.show');
        Route::delete('{log}', 'LogsController@delete')->name('logs.delete');
    });

    Route::get('', 'AdminController@index')->name('admin.index');
});

// Resource Controller - common methods
Route::get('resource/autocomplete', ['uses' => 'ResourceController@autocomplete']);

// Permission Controller
Route::post('permission/dt', 'PermissionController@index')->name('permission.dt');
Route::delete('permission/{permission?}', 'PermissionController@destroy')->name('permission.delete');
Route::resource('permission', 'PermissionController', ['except' => ['destroy']]);

// Role Controller
Route::post('role/dt', 'RoleController@index')->name('role.dt');
Route::delete('role/{role?}', 'RoleController@destroy')->name('role.delete');
Route::resource('role', 'RoleController', ['except' => ['destroy']]);

// User Controller
Route::post('user/dt', 'UserController@index')->name('user.dt');
Route::delete('user/{user?}', 'UserController@destroy')->name('user.delete');
Route::resource('user', 'UserController', ['except' => ['destroy']]);

// Team Controller
Route::post('team/dt', 'TeamController@index')->name('team.dt');
Route::delete('team/{team?}', 'TeamController@destroy')->name('team.delete');
Route::resource('team', 'TeamController', ['except' => ['destroy']]);

// Brand Controller
Route::post('brand/dt', 'BrandController@index')->name('brand.dt');
Route::delete('brand/{brand?}', 'BrandController@destroy')->name('brand.delete');
Route::resource('brand', 'BrandController', ['except' => ['destroy']]);

// Store Controller
Route::resource('store', 'StoreController', ['names' => ['destroy' => 'store.delete']]);

// Chemical Controller
Route::post('chemical/dt', 'ChemicalController@index')->name('chemical.dt');
Route::get('chemical/{chemical}/get-sds', ['as' => 'chemical.get-sds', 'uses' => 'ChemicalController@getSDS']);
Route::group(['prefix' => 'chemical/ajax'], function () {
    Route::get('check-brand', ['as' => 'chemical.check-brand', 'uses' => 'ChemicalController@checkBrand']);
    Route::get('parse', 'ChemicalController@parse');
});
Route::delete('chemical/{chemical?}', 'ChemicalController@destroy')->name('chemical.delete');
Route::resource('chemical', 'ChemicalController', ['except' => ['destroy']]);

// ChemicalItem Controller
Route::patch('chemical-item/move', ['as' => 'chemical-item.move', 'uses' => 'ChemicalItemController@move']);
Route::delete('chemical-item/{item?}', ['as' => 'chemical-item.delete', 'uses' => 'ChemicalItemController@destroy']);
Route::resource('chemical-item', 'ChemicalItemController', [
    'only' => ['store', 'update'],
    'parameters' => ['chemical-item' => 'item']
]);

// NMR Controller
Route::post('nmr/dt', 'NmrController@index')->name('nmr.dt');
Route::get('nmr/{nmr}/download', 'NmrController@download')->name('nmr.download');
Route::delete('nmr/{nmr?}', 'NmrController@destroy')->name('nmr.delete');
Route::resource('nmr', 'NmrController', ['only' => ['index', 'create', 'store']]);
