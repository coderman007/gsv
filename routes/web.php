<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\Users\UserList;
use App\Livewire\Clients\ClientList;
use App\Livewire\Notification;
use App\Livewire\Projects\ProjectList;
use App\Livewire\Quotations\QuotationList;

// use App\Http\Controllers\QuotationController;


Route::get('/',         [HomeController::class, 'welcome'])->name('welcome');
Route::get('/help',    [HomeController::class, 'help'])->name('help');
Route::get('/settings',     [HomeController::class, 'settings'])->name('settings');
Route::get('/policies', [HomeController::class, 'policies'])->name('policies');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/manual',    [HomeController::class, 'manual'])->name('manual');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('users', UserList::class)->name('users');
    Route::get('clients', ClientList::class)->name('clients');
    Route::get('notifications', Notification::class)->name('notifications');
    Route::get('projects', ProjectList::class)->name('projects');
    Route::get('quotations', QuotationList::class)->name('quotations');
});
