<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load the routes for broadcasting
        Broadcast::routes();

        // Define your channels in this method
        Broadcast::channel('admin', function ($user) {
            return $user->role === 'admin'; // Adjust based on your user role logic
        });

        // Load additional channel definitions from channels.php
        require base_path('routes/channels.php');
    }
}
