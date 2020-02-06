<?php

use ChemLab\Helpers\RouteGenerator;
use ChemLab\Models\Brand;
use ChemLab\Models\Chemical;
use ChemLab\Models\Permission;
use ChemLab\Models\Role;
use ChemLab\Models\Store;
use ChemLab\Models\Team;
use ChemLab\Models\User;

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

Route::group(['prefix' => 'api'], function () {
    // Authentication routes
    //Auth::routes(['verify' => true]);
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::post('register', 'RegisterController@register');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    });

    Route::group(['middleware' => 'auth'], function () {
        // User profile
        Route::group(['prefix' => 'profile'], function () {
            Route::get('', 'ProfileController@index')->name('profile.index');
            Route::put('', 'ProfileController@update')->name('profile.update');
            Route::post('password', 'ProfileController@password')->name('profile.password');
        });

        // Advanced administration
        Route::group(['namespace' => 'Advanced', 'middleware' => 'permission:advanced'], function () {
            /**
             * Audits routes
             */
            Route::group(['prefix' => 'audits'], function () {
                Route::get('', 'AuditController@index')->name('audits.index');
                Route::get('refs', 'AuditController@refs')->name('audits.refs');
                Route::get('{audit}', 'AuditController@show')->name('audits.show');
            });

            /**
             * Backups routes
             */
            Route::group(['prefix' => 'backups'], function () {
                Route::get('', 'BackupController@index')->name('backups.index');
                Route::get('refs', 'BackupController@refs')->name('backups.refs');
                Route::get('run', 'BackupController@run')->name('backups.run');
                Route::get('{name}', 'BackupController@download')->name('backups.download');
                Route::delete('{name?}', 'BackupController@delete')->name('backups.delete');
            });

            /**
             * Cache routes
             */
            Route::group(['prefix' => 'cache'], function () {
                Route::get('clear/{path}', 'CacheController@clear')->name('cache.clear');
            });

            /**
             * Cron routes
             */
            Route::group(['prefix' => 'cron'], function () {
                Route::get('backup', 'CronController@backup')->name('cron.backup');
                Route::get('queue', 'CronController@queue')->name('cron.queue');
            });

            /**
             * Logs routes
             */
            Route::group(['prefix' => 'logs'], function () {
                Route::get('', 'LogController@index')->name('logs.index');
                Route::get('refs', 'LogController@refs')->name('logs.refs');
                Route::get('{name}', 'LogController@show')->name('logs.show');
                Route::delete('{name?}', 'LogController@delete')->name('logs.delete');
            });

            /**
             * Jobs routes
             */
            Route::group(['prefix' => 'jobs'], function () {
                Route::get('', 'JobController@index')->name('jobs.index');
                Route::get('refs', 'JobController@refs')->name('jobs.refs');
                Route::get('run', 'JobController@runNextJob')->name('jobs.run');
                Route::get('run-queue', 'JobController@runQueue')->name('jobs.runQueue');
                Route::get('{job}', 'JobController@show')->name('jobs.show');
                Route::delete('{job?}', 'JobController@delete')->name('jobs.delete');
            });
        });

        // Access Control List / Management
        Route::group(['namespace' => 'ACL', 'middleware' => 'permission:acl'], function () {
            /**
             * Permissions routes
             */
            RouteGenerator::create(Permission::class);

            /**
             * Roles routes
             */
            RouteGenerator::create(Role::class);

            /**
             * Users routes
             */
            RouteGenerator::create(User::class);

            /**
             * Teams routes
             */
            RouteGenerator::create(Team::class);
        });

        /**
         * Brands routes
         */
        RouteGenerator::create(Brand::class);

        /**
         * Stores routes
         */
        RouteGenerator::create(Store::class);

        /**
         * Chemicals routes
         */
        RouteGenerator::create(Chemical::class);
        Route::group(['prefix' => 'chemicals'], function () {
            Route::post('check-brand', 'ChemicalController@checkBrand')->name('chemical.check-brand');
            Route::get('parse', 'ChemicalControllers@parse')->name('chemical.parse');
            Route::get('{chemical}/structure', 'ChemicalController@show')->name('chemical.structure');
        });
    });

    // Anything else -> invalid
    Route::get('{any?}', 'HomeController@invalid')->where('any', '.*');
});

Route::get('password/reset/{token}', 'HomeController@index')
    ->middleware('guest')
    ->name('password.reset');

// Match anything else to index -> SPA
Route::get('{any?}', 'HomeController@index')->where('any', '.*')->name('home');


/*

// ChemicalItem Controller
Route::patch('chemical-item/move', ['as' => 'chemical-item.move', 'uses' => 'ChemicalItemController@move']);
Route::delete('chemical-item/{item?}', ['as' => 'chemical-item.delete', 'uses' => 'ChemicalItemController@destroy']);
Route::resource('chemical-item', 'ChemicalItemController', [
    'only' => ['store', 'update'],
    'parameters' => ['chemical-item' => 'item']
]);

*/
