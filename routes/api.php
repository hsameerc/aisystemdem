<?php

use App\Http\Controllers\Api\V1\SupportAppController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user/status', [UsersController::class, 'status']);
        Route::get('/support/dashboard', [SupportAppController::class, 'dashboard']);
        Route::get('/support/model', [SupportAppController::class, 'getModels']);
        Route::get('/support/model/{id}', [SupportAppController::class, 'viewModel']);
        Route::post('/support/model/', [SupportAppController::class, 'createModel']);
        Route::put('/support/model/{id}', [SupportAppController::class, 'updateModel']);
        Route::delete('/support/model/{id}', [SupportAppController::class, 'deleteModel']);

        Route::post('/support/model/{id}/test', [SupportAppController::class, 'testModel']);
        Route::get('/support/model/{id}/supportdata', [SupportAppController::class, 'getFineTunes']);
        Route::post('/support/model/{id}/supportdata', [SupportAppController::class, 'createFineTune']);

        Route::post('/support/model/{id}/supportdata/import', [SupportAppController::class, 'importFineTune']);

        Route::put('/support/model/supportdata/{id}', [SupportAppController::class, 'updateFineTune']);
        Route::delete('/support/model/supportdata/{id}', [SupportAppController::class, 'deleteFineTune']);

        Route::get('/support/model/{id}/validate', [SupportAppController::class, 'validateModel']);
        Route::get('/support/model/{id}/finetune', [SupportAppController::class, 'fineTuneModel']);
    });

});
