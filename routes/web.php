<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', function () {
        return view('tickets.index');
    })->name('tickets.index');

    Route::get('/tickets/create', function () {
        return view('tickets.create');
    })->name('tickets.create');

    Route::get('/tickets/{ticket}', function (\App\Models\Ticket $ticket) {
        return view('tickets.show', compact('ticket'));
    })->name('tickets.show');
});

require __DIR__.'/auth.php';
