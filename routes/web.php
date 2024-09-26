<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\ChannelController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ConferenceController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\TicketController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('event')->controller(EventController::class)->group(function () {
       Route::post('create', 'create')->name('event.create');
       Route::get('detail/{eventId}', 'detail')->name('event.detail');
       Route::post('edit/{eventId}', 'edit')->name('event.edit');
       Route::post('delete/{eventId}', 'delete')->name('event.delete');
    });

    Route::prefix('tickets')->controller(TicketController::class)->group(function () {
        Route::post('create', 'create')->name('ticket.create');
        Route::post('edit/{ticketId}', 'edit')->name('ticket.edit');
        Route::post('delete/{ticketId}', 'delete')->name('ticket.delete');
    });

    Route::prefix('conferences')->controller(ConferenceController::class)->group(function () {
        Route::post('create', 'create')->name('conference.create');
        Route::post('edit/{conferenceId}', 'edit')->name('conference.edit');
        Route::post('delete/{conferenceId}', 'delete')->name('conference.delete');
    });

    Route::prefix('channels')->controller(ChannelController::class)->group(function () {
        Route::post('create', 'create')->name('channel.create');
        Route::post('edit/{channelId}', 'edit')->name('channel.edit');
        Route::post('delete/{channelId}', 'delete')->name('channel.delete');
    });

    Route::prefix('rooms')->controller(RoomController::class)->group(function () {
        Route::post('create', 'create')->name('room.create');
        Route::post('edit/{roomId}', 'edit')->name('room.edit');
        Route::post('delete/{roomId}', 'delete')->name('room.delete');
    });


});




require __DIR__.'/auth.php';
