<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Livewire\NewTicket;
use App\Livewire\ViewTicket;
use App\Livewire\TicketList;
use App\Livewire\Counter;

Route::get('/counter', Counter::class);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('new-ticket', NewTicket::class)
    ->middleware(['auth', 'verified'])
    ->name('new-ticket');

Route::get('view-ticket/{id}', ViewTicket::class)
    ->middleware(['auth', 'verified'])
    ->name('view-ticket');

Route::get('tickets', TicketList::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
