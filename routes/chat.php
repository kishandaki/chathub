<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chat\ConversationController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Chat\PresenceController;
use App\Http\Controllers\Chat\DeviceController;
use App\Http\Controllers\Chat\NotificationPreferenceController;

Route::middleware(['auth', 'protected'])->prefix('chat')->name('chat.')->group(function () {
    // Conversations
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::post('/conversations/direct', [ConversationController::class, 'startDirect'])->name('conversations.direct');
    Route::post('/conversations/group', [ConversationController::class, 'createGroup'])->name('conversations.group');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::patch('/conversations/{conversation}', [ConversationController::class, 'update'])->name('conversations.update');
    Route::post('/conversations/{conversation}/members', [ConversationController::class, 'addMembers'])->name('conversations.members.add');
    Route::delete('/conversations/{conversation}/members/{userId}', [ConversationController::class, 'removeMember'])->name('conversations.members.remove');
    Route::post('/conversations/{conversation}/leave', [ConversationController::class, 'leave'])->name('conversations.leave');
    Route::post('/conversations/{conversation}/pin', [ConversationController::class, 'pin'])->name('conversations.pin');
    Route::delete('/conversations/{conversation}/pin', [ConversationController::class, 'unpin'])->name('conversations.unpin');
    Route::post('/conversations/{conversation}/mute', [ConversationController::class, 'mute'])->name('conversations.mute');
    Route::delete('/conversations/{conversation}/mute', [ConversationController::class, 'unmute'])->name('conversations.unmute');

    // Messages
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{message}/read', [MessageController::class, 'markRead'])->name('messages.read');
    Route::patch('/messages/{message}/delivered', [MessageController::class, 'markDelivered'])->name('messages.delivered');
    Route::delete('/messages/{message}', [MessageController::class, 'delete'])->name('messages.delete');
    Route::delete('/messages/{message}/everyone', [MessageController::class, 'deleteForEveryone'])->name('messages.delete_everyone');
    Route::get('/messages/search', [MessageController::class, 'search'])->name('messages.search');
    Route::post('/messages/{message}/attachments', [MessageController::class, 'uploadAttachment'])->name('messages.attachments.upload');
    Route::get('/attachments/{attachment}/preview', [MessageController::class, 'previewAttachment'])->name('attachments.preview');
    Route::get('/attachments/{attachment}/download', [MessageController::class, 'downloadAttachment'])->name('attachments.download');

    // Presence
    Route::post('/presence/online', [PresenceController::class, 'online'])->name('presence.online');
    Route::post('/presence/offline', [PresenceController::class, 'offline'])->name('presence.offline');
    Route::get('/presence/{userId}', [PresenceController::class, 'show'])->name('presence.show');

    // Devices
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
    Route::delete('/devices/{device}', [DeviceController::class, 'revoke'])->name('devices.revoke');

    // Notification preferences
    Route::get('/notification-preferences', [NotificationPreferenceController::class, 'show'])->name('notification_preferences.show');
    Route::put('/notification-preferences', [NotificationPreferenceController::class, 'update'])->name('notification_preferences.update');
});