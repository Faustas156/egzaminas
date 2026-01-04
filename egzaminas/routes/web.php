<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tickets', TicketController::class);
    Route::get('/ticketsystem', [TicketController::class, 'allTickets'])->name('ticketsystem');
    // Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create'); //create tickets
    // Route::get('/ticketsystem', [TicketController::class, 'allTickets'])->name('ticketsystem'); //view all tickets, doesn't work because index brokey
    // Route::post('/dashboard', [TicketController::class, 'store'])->name('tickets.store');


});

require __DIR__.'/auth.php';
