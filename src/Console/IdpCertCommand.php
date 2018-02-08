<?php
/**
 * Created by PhpStorm.
 * User: raf
 * Date: 07/02/2018
 * Time: 4:49 PM
 */

namespace Raftalks\SAML\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use phpseclib\Crypt\RSA;
use Raftalks\SAML\Identity;

class IdpCertCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:keys {--force : Overwrite Self Signed Certificate, if they already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the key and certificate used to sign SAML messages';


    /**
     * Execute the console command.
     *
     * @param  RSA  $rsa
     * @return mixed
     */
    public function handle(RSA $rsa)
    {
        $keys = $rsa->createKey(2048);
        list($publicKey, $privateKey) = [
            Identity::getKeyPath('saml_idrsa.pub'),
            Identity::getKeyPath('saml_idrsa.key'),
        ];

        if(Storage::disk(config('saml.disk.driver', 'local'))->exists($publicKey)
            || Storage::disk(config('saml.disk.driver', 'local'))->exists($privateKey) &&  ! $this->option('force'))
        {
            return $this->error('keys already exist. Use the --force option to overwrite them.');
        }

        Storage::disk(config('saml.disk.driver', 'local'))->put($publicKey, array_get($keys, 'publickey'));
        Storage::disk(config('saml.disk.driver', 'local'))->put($privateKey, array_get($keys, 'publickey'));

        $this->info('keys generated successfully.');
    }
}