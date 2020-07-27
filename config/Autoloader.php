<?php

class Autoloader 
{
    private static $_directories = [
        'controller/', 
        'model/entity/', 
        'model/manager/', 
        'view/frontView',
        'view/backView',
        'config/'];

    public function __construct()
    {
        spl_autoload_register(self::classLoader($className))
    }

    public static function classLoader($className)
    {
        foreach (self::$_directories as $directory) {

            $fileName = $directory . $className . '.php';

            if (file_exists($fileName)) {
                require_once $fileName;
            }
        }
    }
}