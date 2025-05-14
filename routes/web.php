<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'access'], function () {
    Auth::routes(['verify' => true, 'register' => true]);
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/app/{vue_capture?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->where(
    'vue_capture',
    '[\/\w\.-]*'
);
Route::get('me', [UsersController::class, 'index'])->middleware(['auth']);
