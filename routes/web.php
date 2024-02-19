<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\Users\UserList;
use App\Livewire\Clients\ClientList;
use App\Livewire\Layouts\LayoutList;
use App\Livewire\ProjectCategories\ProjectCategoryList;
use App\Livewire\ProjectTypes\ProjectTypeList;
use App\Livewire\Projects\ProjectList;
use App\Livewire\Quotations\QuotationList;
use App\Livewire\Resources\Labors\LaborList;
use App\Livewire\Resources\Transports\TransportList;
use App\Livewire\Resources\Materials\MaterialList;
use App\Livewire\Resources\Tools\ToolList;

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
    Route::get('projects', ProjectList::class)->name('projects');
    Route::get('project-categories', ProjectCategoryList::class)->name('project-categories');
    Route::get('project-types', ProjectTypeList::class)->name('project-types');
    Route::get('quotations', QuotationList::class)->name('quotations');
    // Route::get('resources', ResourceList::class)->name('resources');
    Route::get('labors', LaborList::class)->name('labors');
    Route::get('transports', TransportList::class)->name('transports');
    Route::get('materials', MaterialList::class)->name('materials');
    Route::get('tools', ToolList::class)->name('tools');
    Route::get('layouts', LayoutList::class)->name('layouts');
});
