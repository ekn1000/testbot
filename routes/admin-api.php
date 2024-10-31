<?php


use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Laravue\JsonResponse;
use \App\Laravue\Acl;
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
use App\Http\Controllers\Admin\Api\AuthController;
use App\Http\Controllers\Admin\Api\UserController;
use App\Http\Controllers\Admin\Api\PermissionController;
use App\Http\Controllers\Admin\Api\ProjectGroupController;
use App\Http\Controllers\Admin\Api\ProjectController;
use App\Http\Controllers\Admin\Api\ProjectKeyController;
use App\Http\Controllers\Admin\Api\ProjectKeyTaskController;
use App\Http\Controllers\Admin\Api\HandleStatusController;
use App\Http\Controllers\Admin\Api\ProjectKeyStatisticController;
use App\Http\Controllers\Admin\Api\BreadcrumbsController;
use App\Http\Controllers\Admin\Api\testbotStatisticController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/admin-login', [AuthController::class, 'adminLogin']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/user/{id}/show', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/{id}/update', [UserController::class,'update']);
    Route::post('/user/{id}/change-password', [UserController::class,'changePassword']);
    Route::post('/user/{id}/delete', [UserController::class, 'destroy']);

    Route::apiResource('/project-groups', ProjectGroupController::class);
    Route::get('/project-groups-options',[ProjectGroupController::class, 'getOptionList']);
    Route::post('/project-groups-generate-api-key/{id}', [ProjectGroupController::class, 'generateApiKey']);

    Route::apiResource('/projects', ProjectController::class);
    Route::get('/projects-options',[ProjectController::class, 'getOptionList']);

    Route::apiResource('/project-keys', ProjectKeyController::class);
    Route::post('/project-key/mass-create', [ProjectKeyController::class, 'massCreate']);
    Route::post('/project-key/mass-edit', [ProjectKeyController::class, 'massEdit']);
    Route::post('/project-key/mass-delete', [ProjectKeyController::class, 'massDestroy']);
    Route::post('/project-key/import', [ProjectKeyController::class, 'Import']);

    Route::apiResource('/project-key-tasks', ProjectKeyTaskController::class);
    Route::get('/project-key-task/filter-options', [ProjectKeyTaskController::class, 'filterOptions']);

    Route::get('/project-key-statistics', [ProjectKeyStatisticController::class, 'index']);
    Route::get('/project-key-statistics/{id}', [ProjectKeyStatisticController::class, 'show']);

    Route::get('/breadcrumbs', [BreadcrumbsController::class, 'index']);

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');

    Route::post('/handle-status', [HandleStatusController::class, 'handleStatus']);
    Route::post('/handle-batch-status', [HandleStatusController::class, 'handleBatchStatus']);

    Route::get('/i-bot-statistics', [testbotStatisticController::class, 'index']);
});

