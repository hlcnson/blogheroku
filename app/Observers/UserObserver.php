<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        // Sự kiện này xảy ra trước khi record đã được save vào DB
        // Xem: https://laravel.com/docs/5.5/eloquent#observers
        // Nắm bắt sự kiện và tạo api_token cho user như thể đang ở trong UserController
        $user->api_token = bin2hex(openssl_random_pseudo_bytes(30));
    }

    
}