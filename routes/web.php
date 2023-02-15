<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalPaymentController;

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

Route::group(['middleware' => ['install']], function () {

    Auth::routes([
        'verify'=> true
    ]);

    // Paypal Payment
    Route::post('pay', [PaypalPaymentController::class, 'pay'])->name('payment')->middleware('auth');
    Route::get('/success/', [PaypalPaymentController::class, 'success']);
    Route::get('/error', [PaypalPaymentController::class, 'error']);

    // Google Auth
    Route::get('auth/google', 'App\Http\Controllers\GoogleController@redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'App\Http\Controllers\GoogleController@handleGoogleCallback');

    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('index');
    // Route::get('logincheck', 'App\Http\Controllers\HomeController@logincheck')->name('logincheck');

    Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::post('/promotions/video', 'App\Http\Controllers\PromotionController@upload');

    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showUserLoginForm')->name('login');
    Route::get('/admin-login', 'App\Http\Controllers\Auth\LoginController@showAdminLoginForm')->name('admin.login');

    //auth
    Route::group(['middleware' => ['auth', 'is_admin']], function () {

        Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

        //Profile Controller
        Route::get('/profile/show', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
        Route::get('/profile/edit', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
        Route::post('/profile/update', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
        Route::get('/password/change', 'App\Http\Controllers\ProfileController@password_change')->name('password.change');
        Route::post('/password/update', 'App\Http\Controllers\ProfileController@update_password')->name('change.password.update');

        //Settings Controller
        Route::get('/manage_app', 'App\Http\Controllers\SettingController@index');
        Route::any('/general_settings', 'App\Http\Controllers\SettingController@general')->name('general_settings');
        Route::any('/app_settings', 'App\Http\Controllers\SettingController@app')->name('app_settings');
        Route::any('/cache_clear', 'App\Http\Controllers\SettingController@cache_clear')->name('cache_clear');
        Route::post('/store_settings', 'App\Http\Controllers\SettingController@store_settings')->name('store_settings');

        //Backup Controller
        Route::any('/database_backup', 'App\Http\Controllers\BackupController@index')->name('database_backup');
        Route::get('/notifications/deleteall', 'App\Http\Controllers\NotificationController@deleteall');
        Route::resource('notifications', 'App\Http\Controllers\NotificationController');

        // Live Match Controller
        Route::post('/live_matches/reorder', 'App\Http\Controllers\LiveMatchController@reorder');
        Route::post('/live_matches/reorderStreamingSources', 'App\Http\Controllers\LiveMatchController@reorderStreamingSources');
        Route::resource('live_matches', 'App\Http\Controllers\LiveMatchController');
		Route::resource('highlights', 'App\Http\Controllers\HighlightController');
        Route::resource('promotions', 'App\Http\Controllers\PromotionController');

        //UserController
        Route::get('users/app/{app_unique_id}', [App\Http\Controllers\UserController::class, 'index']);
        Route::resource('users', App\Http\Controllers\UserController::class);

        //SubscriptionController
        Route::get('/subscriptions/', [App\Http\Controllers\SubscriptionController::class, 'index']);
        Route::resource('subscriptions', App\Http\Controllers\SubscriptionController::class);

        //PaymentController
        Route::resource('payments', App\Http\Controllers\PaymentController::class);

        // PaypalPaymentController
        Route::get('/paypal-payments/index', [PaypalPaymentController::class, 'index'])->name('paypal_payment.index');
        Route::get('/paypal-payments/modal/{id}/show', [PaypalPaymentController::class, 'show'])->name('paypal_payments.modal.show');

        Route::get('update/{table}/{id}/{field}/{value}', function($table, $id, $field, $value){
            \DB::table($table)->where('id', $id)->update([$field => $value]);

            return response()->json(['result' => 'success', 'message' => _lang( $field . ' has been updated sucessfully.')]);
        });

    });

});

Route::get('/cache', function(){
	cache()->flush();
});

Route::get('/log-clear', function(){
    exec('rm -f ' . storage_path('logs/*.log'));
    exec('rm -f ' . base_path('*.log'));
});

Route::get('/ip', function(Request $request){
    return $request->getClientIp(true);
});

//Install Controller©
Route::get('/installation', 'App\Http\Controllers\Install\InstallController@index');
Route::get('install/database', 'App\Http\Controllers\Install\InstallController@database');
Route::post('install/process_install', 'App\Http\Controllers\Install\InstallController@process_install');
Route::get('install/create_user', 'App\Http\Controllers\Install\InstallController@create_user');
Route::post('install/store_user', 'App\Http\Controllers\Install\InstallController@store_user');
Route::get('install/system_settings', 'App\Http\Controllers\Install\InstallController@system_settings');
Route::post('install/finish', 'App\Http\Controllers\Install\InstallController@final_touch');

Route::get('/server_cache_clear', 'App\Http\Controllers\WebsiteController@server_cache_clear');
