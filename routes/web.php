<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationDocumentController;
use App\Livewire\Clients\ClientCreate;
use App\Livewire\Clients\ClientList;
use App\Livewire\Layouts\LayoutList;
use App\Livewire\ProjectCategories\ProjectCategoryList;
use App\Livewire\Projects\ProjectList;
use App\Livewire\Quotations\QuotationCreate;
use App\Livewire\Quotations\QuotationList;
use App\Livewire\Resources\Additionals\AdditionalList;
use App\Livewire\Resources\CommercialPolicies\CommercialPolicyList;
use App\Livewire\Resources\Irradiances\IrradianceEdit;
use App\Livewire\Resources\MacroEconomicVariables;
use App\Livewire\Resources\Materials\MaterialList;
use App\Livewire\Resources\Positions\PositionList;
use App\Livewire\Resources\Tools\ToolList;
use App\Livewire\Resources\Transports\TransportList;
use App\Livewire\Users\UserList;
use Illuminate\Support\Facades\Route;

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
    Route::get('clients-create', ClientCreate::class)->name('clients-create');
    Route::get('projects', ProjectList::class)->name('projects');
    Route::get('project-categories', ProjectCategoryList::class)->name('project-categories');
    Route::get('quotations', QuotationList::class)->name('quotations');
    Route::get('quotations/create', QuotationCreate::class)->name('quotation-create');
    Route::get('/quotations/{id}/pdf', [QuotationController::class, 'downloadQuotationPDF'])->name('quotations.pdf');

    // Route::get('resources', ResourceList::class)->name('resources');
    Route::get('positions', PositionList::class)->name('positions');
    Route::get('materials', MaterialList::class)->name('materials');
    Route::get('tools', ToolList::class)->name('tools');
    Route::get('transports', TransportList::class)->name('transports');
    Route::get('additionals', AdditionalList::class)->name('additionals');
    Route::get('commercial-policies', CommercialPolicyList::class)->name('commercial-policies');
    Route::get('layouts', LayoutList::class)->name('layouts');
    Route::get('irradiances', IrradianceEdit::class)->name('irradiances');
    Route::get('macro-economic-variables', MacroEconomicVariables::class)->name('macro-economic-variables.index');
    Route::get('/quotations/{id}/download-word', [QuotationDocumentController::class, 'downloadQuotation'])->name('quotations.download-word');

});

