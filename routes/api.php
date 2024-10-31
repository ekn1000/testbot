<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\ProjectKeyTaskController;

Route::match(['get', 'post'],'/gettask/{api_key}', [ProjectKeyTaskController::class, 'getTask'])->name('get-task');

Route::match(['get', 'post'], '/update-task',[ProjectKeyTaskController::class, 'update']);

use App\Http\Controllers\Api\ProjectGroupController;

Route::match(['get', 'post'], '/gettaskfromprojectgroup/{api_key}', [ProjectGroupController::class, 'getTaskFromProjectGroup']);
