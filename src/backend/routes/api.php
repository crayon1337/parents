<?php

declare(strict_types=1);

use App\Http\Controllers\API\UserController;
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


Route::group(
    attributes: [
        'prefix' => 'v1',
    ],
    routes: function (): void {
        Route::group(
            attributes: [
                'prefix' => 'users',
                'as' => 'users.'
            ],
            routes: function (): void {
                Route::get(uri: '/', action: [UserController::class, 'index'])->name(name: 'index');
            }
        );
    }
);
