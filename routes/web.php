<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AssistanceRequestController;
use App\Http\Controllers\Admin\RequestTypeController;
use App\Http\Controllers\Admin\RequestCategoryController;
use App\Http\Controllers\Admin\RequestSubcategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('assistance-requests', AssistanceRequestController::class);
    Route::post('assistance-requests/{assistanceRequest}/submit', [AssistanceRequestController::class, 'submit'])->name('assistance-requests.submit');
    Route::post('assistance-requests/{assistanceRequest}/agent-review', [AssistanceRequestController::class, 'verifyByAgent'])->name('assistance-requests.agent-review');
    Route::post('assistance-requests/{assistanceRequest}/jk-recommendation', [AssistanceRequestController::class, 'recommendByJk'])->name('assistance-requests.jk-recommendation');
    Route::post('assistance-requests/{assistanceRequest}/admin-decision', [AssistanceRequestController::class, 'decideByAdmin'])->name('assistance-requests.admin-decision');
    Route::get('assistance-requests/{assistanceRequest}/documents/{document}/download', [AssistanceRequestController::class, 'downloadDocument'])->name('assistance-requests.documents.download');
    Route::get('request-types/{requestType}/categories', [AssistanceRequestController::class, 'getCategories']);
    Route::get('request-categories/{requestCategory}/subcategories', [AssistanceRequestController::class, 'getSubcategories']);

    // Admin Utilities Routes
    Route::prefix('admin/utilities')->name('admin.')->group(function () {
        Route::resource('request-types', RequestTypeController::class);
        Route::resource('request-categories', RequestCategoryController::class);
        Route::resource('request-subcategories', RequestSubcategoryController::class);
    });
});


