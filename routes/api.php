<?php

use App\Http\Controllers\APIs\v1\CustomerController;
use App\Http\Controllers\APIs\v1\LoanController;
use App\Http\Controllers\APIs\v1\LoanRepaymentController;
use App\Http\Controllers\APIs\v1\TestController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * CUSTOMER
 */
Route::apiResource('customers', CustomerController::class);

/**
 * LOAN
 */
Route::post('loans/{loan}/approve', [LoanController::class, 'approve']);
Route::apiResource('loans', LoanController::class)->only([
    'index', 'store'
]); 

/**
 * LOAN REPAYMENT
 */
// Route::get('repay', [LoanRepaymentController::class, 'repay']);
Route::put('loan-repayments/{id}/repay', [LoanRepaymentController::class, 'repay']);
