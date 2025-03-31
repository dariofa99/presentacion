<?php


use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('test-channel', function ($user) {
    Log::info('Usuario autenticado: ' . $user->id);
    return $user; // O una condición para autorizar al usuario
});

Broadcast::channel('chat-channel', function ($user) {
    Log::info('chat autenticado: ' . $user->id);
    return $user; // O una condición para autorizar al usuario
});