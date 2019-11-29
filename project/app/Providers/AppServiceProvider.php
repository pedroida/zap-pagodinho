<?php

namespace App\Providers;

use App\Model\Chat;
use App\Model\Message;
use App\Observers\ChatObserver;
use App\Observers\MessageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Message::observe(MessageObserver::class);
        Chat::observe(ChatObserver::class);
    }
}
