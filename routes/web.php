<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/api/console');
});
Route::get('/migrate',function () {
    return Artisan::call('migrate', ["--force" => true ]);
});
Route::get('/exec',function () {
    return Artisan::call('jwt:secret',["--force" => true ]);
});
Route::get('/migrate/rollback',function () {
    return Artisan::call('migrate:rollback', ["--force" => true ]);
});
Route::get('mail', function () {

    return (new App\Notifications\ResetPasswordNotification("3838388383838388"))
        ->toMail(User::find(1));
});
