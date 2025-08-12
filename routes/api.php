<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    //registration
    Route::post('/register', [AuthController::class, 'register'])->middleware('auth:sanctum');
    //login
    Route::post('/login', [AuthController::class, 'login']);
    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

//enquiries creation
Route::post('/enquiries', [EnquiryController::class, 'store']);

Route::get('/enquiries', [EnquiryController::class, 'index'])->middleware('auth:sanctum');

Route::put('/enquiries/{enquiry}/assign', [EnquiryController::class, 'assign'])->middleware('auth:sanctum');

Route::patch('/enquiries/{enquiry}/status', [EnquiryController::class, 'updateStatus'])->middleware('auth:sanctum');
