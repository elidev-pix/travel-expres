<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppwriteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $client = new Client();
            
            $client
                ->setEndpoint(config('appwrite.endpoint'))
                ->setProject(config('appwrite.project_id'))
                ->setKey(config('appwrite.api_key')); // Indispensable pour les actions serveur

            return $client;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
