<?php
/**
 * Created by PhpStorm.
 * User: raf
 * Date: 08/02/2018
 * Time: 11:38 AM
 */

namespace Raftalks\SAML;


use Illuminate\Support\ServiceProvider;
use Raftalks\SAML\Console\IdpCertCommand;

class SamlServiceProvider extends ServiceProvider
{


    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../resources/config/saml.php' => config_path('saml.php')
            ], 'config');

            $this->commands([
                IdpCertCommand::class
            ]);
        }

    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../resources/config/saml.php', 'saml'
        );
    }

}