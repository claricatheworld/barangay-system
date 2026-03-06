<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-official-email', [AuthController::class, 'verifyOfficialEmail'])->name('verify-official-email');

Route::get('/pending', function () {
    return view('pending');
})->name('pending');

Route::get('/unauthorized', function () {
    return view('unauthorized');
});

/*
|--------------------------------------------------------------------------
| Resident Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'resident'])->prefix('resident')->group(function () {
    Route::get('/dashboard', [ResidentController::class, 'dashboard'])->name('resident.dashboard');
    Route::get('/profile', [ResidentController::class, 'profile'])->name('resident.profile');
    Route::put('/profile', [ResidentController::class, 'updateProfile'])->name('resident.profile.update');
    Route::get('/online-id', [ResidentController::class, 'onlineId'])->name('resident.online-id');
    Route::post('/online-id/photo', [ResidentController::class, 'updateIdPhoto'])->name('resident.online-id.photo');
    Route::get('/notifications', [ResidentController::class, 'notifications'])->name('resident.notifications');
    Route::post('/notifications/{id}/read', [ResidentController::class, 'markRead']);

    Route::get('/chat/thread', [ChatController::class, 'residentThread'])->name('resident.chat.thread');
    Route::get('/chat/messages', [ChatController::class, 'residentMessages'])->name('resident.chat.messages');
    Route::post('/chat/messages', [ChatController::class, 'residentSend'])->name('resident.chat.send');
});

/*
|--------------------------------------------------------------------------
| Official Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'official'])->prefix('official')->group(function () {
    Route::get('/dashboard', [OfficialController::class, 'dashboard'])->name('official.dashboard');
    
    // Resident management
    Route::get('/residents', [OfficialController::class, 'residents'])->name('official.residents.index');
    Route::get('/residents/create', [OfficialController::class, 'createResident'])->name('official.residents.create');
    Route::post('/residents', [OfficialController::class, 'storeResident'])->name('official.residents.store');
    Route::get('/residents/{id}/edit', [OfficialController::class, 'editResident'])->name('official.residents.edit');
    Route::put('/residents/{id}', [OfficialController::class, 'updateResident'])->name('official.residents.update');
    Route::post('/residents/{id}/approve', [OfficialController::class, 'approveResident'])->name('official.residents.approve');
    Route::post('/residents/{id}/reject', [OfficialController::class, 'rejectResident'])->name('official.residents.reject');
    Route::delete('/residents/{id}', [OfficialController::class, 'deleteResident'])->name('official.residents.destroy');
    
    // Profile
    Route::get('/profile', [OfficialController::class, 'profile'])->name('official.profile');
    Route::put('/profile', [OfficialController::class, 'updateProfile'])->name('official.profile.update');

    // Chat
    Route::get('/chat', [ChatController::class, 'officialIndex'])->name('official.chat.index');
    Route::get('/chat/threads', [ChatController::class, 'officialThreads'])->name('official.chat.threads');
    Route::get('/chat/threads/{thread}/messages', [ChatController::class, 'officialMessages'])->name('official.chat.messages');
    Route::post('/chat/threads/{thread}/messages', [ChatController::class, 'officialSend'])->name('official.chat.send');
    
    // Notifications
    Route::get('/notifications/create', [OfficialController::class, 'createNotification'])->name('official.notifications.create');
    Route::post('/notifications', [OfficialController::class, 'sendNotification'])->name('official.notifications.store');
    
    // Announcements
    Route::get('/announcements', [OfficialController::class, 'announcements'])->name('official.announcements.index');
    Route::get('/announcements/create', [OfficialController::class, 'createAnnouncement'])->name('official.announcements.create');
    Route::post('/announcements', [OfficialController::class, 'storeAnnouncement'])->name('official.announcements.store');
    Route::get('/announcements/{id}/edit', [OfficialController::class, 'editAnnouncement'])->name('official.announcements.edit');
    Route::put('/announcements/{id}', [OfficialController::class, 'updateAnnouncement'])->name('official.announcements.update');
    Route::delete('/announcements/{id}', [OfficialController::class, 'deleteAnnouncement'])->name('official.announcements.destroy');
    Route::post('/announcements/{id}/toggle', [OfficialController::class, 'toggleAnnouncement'])->name('official.announcements.toggle');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Official management
    Route::get('/officials', [AdminController::class, 'officials'])->name('admin.officials.index');
    Route::get('/officials/create', [AdminController::class, 'createOfficial'])->name('admin.officials.create');
    Route::post('/officials', [AdminController::class, 'storeOfficial'])->name('admin.officials.store');
    Route::delete('/officials/{id}', [AdminController::class, 'deleteOfficial'])->name('admin.officials.destroy');
});

