<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ItineraryController;
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
//get enquiries
Route::get('/enquiries', [EnquiryController::class, 'index'])->middleware('auth:sanctum');
//assign agent
Route::put('/enquiries/{enquiry}/assign', [EnquiryController::class, 'assign'])->middleware('auth:sanctum');
//update status
Route::patch('/enquiries/{enquiry}/status', [EnquiryController::class, 'updateStatus'])->middleware('auth:sanctum');


//get Itinerary
Route::get('/itineraries', [ItineraryController::class, 'index'])->middleware('auth:sanctum');
//create Itinerary
Route::post('/itineraries', [ItineraryController::class, 'store'])->middleware('auth:sanctum');
//get itineraries
Route::get('/itineraries/{itinerary}', [ItineraryController::class, 'show'])->middleware('auth:sanctum');
//update itinerary
Route::put('/itineraries/{itinerary}', [ItineraryController::class, 'update'])->middleware('auth:sanctum');
//update itinerary
Route::patch('/itineraries/{itinerary}', [ItineraryController::class, 'update'])->middleware('auth:sanctum');
//delete itinerary
Route::delete('/itineraries/{itinerary}', [ItineraryController::class, 'destroy'])->middleware('auth:sanctum');
