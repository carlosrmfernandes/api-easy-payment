<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use App\Components\TransferAuthorization\Client;
use App\Components\TransferAuthorization\Strategies\HopeStrategy;

class HopeAuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->singleton(Client::class, function () {
            $config = config('hope');
            $client = new GuzzleClient([
                'base_uri' => $config['base_uri'],
            ]);
            return new Client(new HopeStrategy($client));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
