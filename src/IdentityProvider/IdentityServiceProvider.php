<?php
/**
 * Created by PhpStorm.
 * User: raf
 * Date: 07/02/2018
 * Time: 4:25 PM
 */

namespace Raftalks\SAML\IdentityProvider;


use Illuminate\Support\ServiceProvider;
use Raftalks\SAML\Console\IdpCertCommand;

class IdentityServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../../resources/config/saml.php' => config_path('saml.php')
            ], 'config');

            $this->commands([
               IdpCertCommand::class
            ]);
        }

    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../resources/config/saml.php', 'saml'
        );
    }
}