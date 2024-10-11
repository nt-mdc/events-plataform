<?php

use App\Http\Controllers\API\AttendeeController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\RegistrationController;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AttendeeController::class, 'register']);
    Route::post('/login', [AttendeeController::class, 'login']);
    Route::delete('/logout', [AttendeeController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/{eventId}', [EventController::class, 'show']);
    Route::post('conference/register', [RegistrationController::class, 'registerAttendee']);
    Route::delete('conference/unregister', [RegistrationController::class, 'removeRegistration']);
});

