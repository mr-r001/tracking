<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade as PDF;

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

Auth::routes();

//Public 
Route::get('/', function () {
    return redirect('/auth');
});
Route::get('/auth', 'Auth\LoginController@adminLogin')->name('adminLogin');

// ROUTE FOR ADMIN ONLY
Route::name('admin.')->prefix('admin')->middleware(['auth', 'admin', 'active', 'check.session'])->group(function () {

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });

    // Dashboard
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

    // Data Customer
    Route::resource('customer', 'CustomerController');

    // Tracking BPKB
    Route::resource('BPKB', 'BPKBController');

    // Tracking STNK
    Route::resource('STNK', 'STNKController');


    // Hak Akses
    Route::resource('user', 'UserController');
    Route::get('change-password', 'UserController@changePassword')->name('changePassword');
    Route::post('update-password', 'UserController@updatePassword')->name('updatePassword');
});
