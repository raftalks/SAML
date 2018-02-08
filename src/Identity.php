<?php
/**
 * Created by PhpStorm.
 * User: raf
 * Date: 07/02/2018
 * Time: 5:05 PM
 */

namespace Raftalks\SAML;


class Identity
{


    static $keyPath;




    public static function setKeyPath($path)
    {
        static::$keyPath = $path;
    }


    public static function getKeyPath($file)
    {
        $file = ltrim($file, '/\\');

        return static::$keyPath
            ? rtrim(static::$keyPath, '/\\').DIRECTORY_SEPARATOR.$file
            : config('saml.disk.pathname') . DIRECTORY_SEPARATOR.$file;
    }

}