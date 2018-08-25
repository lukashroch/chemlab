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
     * Backups routes
     */
    Route::group(['prefix' => 'backups'], function () {
        Route::get('', 'BackupsController@index')->name('backups.index');
        Route::get('cron/{token?}', 'BackupsController@cron')->name('backups.cron');
        Route::get('create', 'BackupsController@create')->name('backups.create');
        Route::get('{name}', 'BackupsController@download')->name('backups.download');
        Route::delete('{name}', 'BackupsController@delete')->name('backups.delete');
    });

    /**
     * Logs routes
     */
    Route::group(['prefix' => 'logs'], function () {
        Route::get('', 'LogsController@index')->name('logs.index');
        Route::get('{name}', 'LogsController@show')->name('logs.show');
        Route::delete('{name}', 'LogsController@delete')->name('logs.delete');
    });

    /**
     * Cache routes
     */
    Route::group(['prefix' => 'cache'], function () {
        Route::get('', 'CacheController@index')->name('cache.index');
        Route::get('clear', 'CacheController@cache')->name('cache.clear');
    });

    Route::get('', ['as' => 'admin.index', 'uses' => 'AdminController@overview']);
});

// Resource Controller - common methods
Route::get('resource/autocomplete', ['uses' => 'ResourceController@autocomplete']);

// Permission Controller
Route::post('permission/dt', 'PermissionController@index')->name('permission.dt');
Route::delete('permission/{permission?}', ['as' => 'permission.delete', 'uses' => 'PermissionController@destroy']);
Route::resource('permission', 'PermissionController', ['except' => ['destroy']]);

// Role Controller
Route::post('role/dt', 'RoleController@index')->name('role.dt');
Route::delete('role/{role?}', ['as' => 'role.delete', 'uses' => 'RoleController@destroy']);
Route::resource('role', 'RoleController', ['except' => ['destroy']]);

// User Controller
Route::post('user/dt', 'UserController@index')->name('user.dt');
Route::delete('user/{user?}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
Route::resource('user', 'UserController', ['except' => ['destroy']]);

// Team Controller
Route::post('team/dt', 'TeamController@index')->name('team.dt');
Route::delete('team/{team?}', ['as' => 'team.delete', 'uses' => 'TeamController@destroy']);
Route::resource('team', 'TeamController', ['except' => ['destroy']]);

// Brand Controller
Route::post('brand/dt', 'BrandController@index')->name('brand.dt');
Route::delete('brand/{brand?}', ['as' => 'brand.delete', 'uses' => 'BrandController@destroy']);
Route::resource('brand', 'BrandController', ['except' => ['destroy']]);

// Store Controller
Route::resource('store', 'StoreController', ['names' => ['destroy' => 'store.delete']]);

// Chemical Controller
Route::post('chemical/dt', 'ChemicalController@index')->name('chemical.dt');
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
Route::post('nmr/dt', 'NmrController@index')->name('nmr.dt');
Route::get('nmr/{nmr}/download', ['as' => 'nmr.download', 'uses' => 'NmrController@download']);
Route::delete('nmr/{nmr?}', ['as' => 'nmr.delete', 'uses' => 'NmrController@destroy']);
Route::resource('nmr', 'NmrController', ['only' => ['index', 'create', 'store']]);
