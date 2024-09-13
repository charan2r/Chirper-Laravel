<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get(uri: '/', action: function (): Factory|View {
    return view(view: 'welcome');
});

Route::get(uri: '/dashboard', action: function (): Factory|View {
    return view(view: 'dashboard');
})->middleware(middleware: ['auth', 'verified'])->name(name: 'dashboard');

Route::get(uri: '/admin', action: [AdminController::class, 'dashboard'])
    ->name(name: 'admin.dashboard')
    ->middleware(middleware: ['auth', 'admin']);

Route::middleware(middleware: 'auth')->group(callback: function (): void {
    Route::get(uri: '/profile', action: [ProfileController::class, 'edit'])->name(name: 'profile.edit');
    Route::patch(uri: '/profile', action: [ProfileController::class, 'update'])->name(name: 'profile.update');
    Route::delete(uri: '/profile', action: [ProfileController::class, 'destroy'])->name(name: 'profile.destroy');
});

Route::resource(name: 'chirps', controller: ChirpController::class)
        ->only(methods: ['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware(middleware: ['auth', 'verified']);

require __DIR__.'/auth.php';
