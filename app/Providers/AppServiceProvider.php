<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listeners\CreateChatRoomOnLoginOrRegister;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registering event listeners
        Event::listen(Registered::class, CreateChatRoomOnLoginOrRegister::class);
        Event::listen(Login::class, CreateChatRoomOnLoginOrRegister::class);
    }
}
