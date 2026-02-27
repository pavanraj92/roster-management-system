<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class MergeGuestCartOnLogin
{
    public function __construct()
    {
    }

    public function handle(Login $event): void
    {
        $request = request();
        $sessionId = $request->cookie('cart_token') ?? $request->session()->getId();
        // if ($sessionId && $event->user) {
        //     $this->cartService->mergeSessionCartIntoUser($sessionId, $event->user->id);
        // }
    }
}
