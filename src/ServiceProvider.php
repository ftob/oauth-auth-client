<?php
namespace Ftob\OAuth2\Client;

/**
 * Class ServiceProvider
 * @package Ftob\OAuth2\Client
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Resources/config/parameter.php', 'oauth'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Resources/config/parameter.php' => config_path('oauth.php'),
        ]);
    }

}