<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminItemController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




// Public routes (No authentication needed)
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);
// Email Verification
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'verified']);

// Routes for authenticated users
Route::middleware(['jwt.verify'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD routes for users' items
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});

// Routes for admins
Route::middleware(['jwt.verify', 'role:admin'])->group(function () {
    // Admin routes to manage items
    Route::get('/admin/items/unapproved', [AdminItemController::class, 'getUnapprovedItems']);
    Route::put('/admin/items/{id}/approve', [AdminItemController::class, 'approveItem']);
    Route::put('/admin/items/{id}/reject', [AdminItemController::class, 'rejectItem']);
    Route::delete('/admin/items/{id}', [AdminItemController::class, 'destroy']);

    //New User Registered Notification
    Route::get('admin/notification', [NotificationController::class, 'notification']);
});
