<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(middleware: 'guest')->group(callback: function (): void {
    Route::get(uri: 'register', action: [RegisteredUserController::class, 'create'])
                ->name(name: 'register');

    Route::post(uri: 'register', action: [RegisteredUserController::class, 'store']);

    Route::get(uri: 'login', action: [AuthenticatedSessionController::class, 'create'])
                ->name(name: 'login');

    Route::post(uri: 'login', action: [AuthenticatedSessionController::class, 'store']);

    Route::get(uri: 'forgot-password', action: [PasswordResetLinkController::class, 'create'])
                ->name(name: 'password.request');

    Route::post(uri: 'forgot-password', action: [PasswordResetLinkController::class, 'store'])
                ->name(name: 'password.email');

    Route::get(uri: 'reset-password/{token}', action: [NewPasswordController::class, 'create'])
                ->name(name: 'password.reset');

    Route::post('reset-password', action: [NewPasswordController::class, 'store'])
                ->name(name: 'password.store');
});

Route::middleware(middleware: 'auth')->group(callback: function (): void {
    Route::get(uri: 'verify-email', action: EmailVerificationPromptController::class)
                ->name(name: 'verification.notice');

    Route::get(uri: 'verify-email/{id}/{hash}', action: VerifyEmailController::class)
                ->middleware(middleware: ['signed', 'throttle:6,1'])
                ->name(name: 'verification.verify');

    Route::post(uri: 'email/verification-notification', action: [EmailVerificationNotificationController::class, 'store'])
                ->middleware(middleware: 'throttle:6,1')
                ->name(name: 'verification.send');

    Route::get(uri: 'confirm-password', action: [ConfirmablePasswordController::class, 'show'])
                ->name(name: 'password.confirm');

    Route::post(uri: 'confirm-password', action: [ConfirmablePasswordController::class, 'store']);

    Route::put(uri: 'password', action: [PasswordController::class, 'update'])->name(name: 'password.update');

    Route::post(uri: 'logout', action: [AuthenticatedSessionController::class, 'destroy'])
                ->name(name: 'logout');
});
