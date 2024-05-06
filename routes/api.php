<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::prefix("/v1")->group(function() {
    Route::middleware('auth:sanctum')->group(function() {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::delete('/users',[V1\AuthController::class, 'logout']);
        Route::post("/posts", [V1\PostController::class, 'create']);
        Route::delete("/posts/{id}", [V1\PostController::class, 'destroy']);
        Route::put("/posts/{id}", [V1\PostController::class, 'update']);

    });

    Route::post('/users',[V1\AuthController::class, 'register']);
    Route::post('/users/login',[V1\AuthController::class, 'login']);

    Route::get("/categories", [V1\CategoryController::class, "get"]);
    Route::get("/posts", [V1\PostController::class, 'getAll']);
    Route::get("/posts/{id}", [V1\PostController::class, 'getByID']);
    Route::get("/storagelink", function(Request $request) {
        Artisan::command("storage:link");
    });
});

