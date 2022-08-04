<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZipCodeController;
use App\Http\Controllers\SettlementController;

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

Route::get('/zip_code/{zip_code}', [SettlementController::class, 'getSettlements'])->name('search_zip_code');
Route::get('/zip_codedb/{zip_code}', [ZipCodeController::class, 'getSettlements'])->name('search_zip_codedb');
