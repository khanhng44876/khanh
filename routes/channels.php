<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::routes(['middleware' => ['web','auth']]);

Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    if ($user->id === Order::find($orderId)->user_id) {
        return true;
    }
    return $user->role === 'admin';
});

