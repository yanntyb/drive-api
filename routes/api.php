<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\StorageController;
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

Route::prefix("user")->group(function(){
    Route::post("/login",[UserController::class, "login"])->name("login");
    Route::post("/register",[UserController::class, "register"])->name("register");
});

Route::middleware("auth:sanctum")->group(function(){
    Route::prefix("user")->group(function(){
        Route::controller(UserController::class)->group(function(){
            Route::post("/me", "info");

            Route::prefix("/storage")->group(function(){
                Route::post("/list","storageList");
            });
        });
    });

    Route::prefix("storage")->group(function(){
        Route::controller(StorageController::class)->group(function(){
            Route::prefix("file")->group(function(){
                Route::post("/add","addFile");
                Route::post("/queue","getQueue");
            });
        });
    });

    //Admin
    Route::middleware("api-admin")->prefix("admin")->group(function(){
        Route::prefix("user")->group(function(){
            Route::controller(UserController::class)->group(function(){
                Route::post("/delete","delete");
            });
        });
    });
});
