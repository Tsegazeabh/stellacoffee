<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PermissionsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RolesController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

//Route::get('/register', [RegisteredUserController::class, 'create'])
//                ->middleware('guest')
//                ->name('register');
//
//Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware('guest');
//
//Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//                ->middleware('guest')
//                ->name('login');
//
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//                ->middleware('guest');
//
//Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
//                ->middleware('guest')
//                ->name('password.request');
//
//Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.email');
//
//Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                ->middleware('guest')
//                ->name('password.reset');
//
//Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.update');
//
//Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
//                ->middleware('auth')
//                ->name('verification.notice');
//
//Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//
//Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                ->middleware('auth')
//                ->name('password.confirm');
//
//Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
//                ->middleware('auth');
//
//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->middleware('auth')
//                ->name('logout');
//
Route::prefix('login')->middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('accounts')->group(function () {

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware('guest')->name('verification.verify');
    Route::get('/unverified-email', [VerifyEmailController::class, 'notifyUnverifiedEmail'])->name('verification.notice');

    Route::middleware(['auth', 'verified', 'password.changed'])->group(function () {
        Route::get('/', [UsersController::class, 'manage'])->name('manage-accounts');
        Route::get(getSecureURL(1), [UsersController::class, 'create'])->name('register-user');
        Route::post(getSecureURL(2), [UsersController::class, 'store'])->name('post-user-account');
        Route::get(getSecureURL(6) . '/{userId}', [UsersController::class, 'getEdit'])->name('user-account-editor-page');
        Route::put(getSecureURL(7) . '/{userId}', [UsersController::class, 'postEdit'])->name('update-user-account');
        Route::post('/fetch-users', [UsersController::class, 'fetchUsers'])->name('fetch-users');
        Route::put('/update-status/{userId}', [UsersController::class, 'toggleStatus'])->name('toggle-account-status');
        Route::put('/send-verification-token/{userId}', [UsersController::class, 'resendEmailVerification'])->name('resend-email-verification');
    });
});

Route::prefix('password')->group(function () {
    Route::prefix('reset/{id}/{token}')->group(function () {
        Route::get('/', [PasswordController::class, 'getResetPassword'])->name('password-reset-page');
        Route::post('/', [PasswordController::class, 'postResetPassword'])->name('reset-password');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::middleware(['password.changed'])->group(function () {
            Route::post('/forgot-password/{id}', [PasswordController::class, 'sendPasswordResetLink'])->name('password.forgot');
        });
        Route::prefix('modify')->group(function () {
            Route::get('/{userId}', [PasswordController::class, 'getModifyPassword'])->name('password-modification-page');
            Route::put('/{userId}', [PasswordController::class, 'postModifyPassword'])->name('update-password');
        });
    });
});

Route::prefix('roles')->middleware(['auth', 'verified', 'password.changed'])->group(function () {
    Route::get('/', [RolesController::class, 'index'])->name('roles-management-page');
    Route::get('all', [RolesController::class, 'getAllRoles'])->name('all-roles');
    Route::get('{id}', [RolesController::class, 'getRole'])->name('fetch-role');
    Route::post('fetch-roles', [RolesController::class, 'fetchRoles'])->name('fetch-roles');
    Route::post('create-role', [RolesController::class, 'addRole'])->name('create-role');
    Route::put('edit-role/{id}', [RolesController::class, 'editRole'])->name('edit-role');
    Route::delete('{id}', [RolesController::class, 'deleteRole'])->name('delete-role');
});

Route::prefix('permissions')->middleware(['auth', 'verified', 'password.changed'])->group(function () {
    Route::get('/', [PermissionsController::class, 'index'])->name('role-permissions-page');
    Route::get('all', [PermissionsController::class, 'getPermissions'])->name('all-permissions');
    Route::get('{role_id}', [PermissionsController::class, 'getRolePermissions'])->name('role-permissions');
    Route::put('{role_id}', [PermissionsController::class, 'updateRolePermissions'])->name('update-role-permissions');
});

