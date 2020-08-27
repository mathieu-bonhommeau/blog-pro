<?php

namespace config;

class Autoloader 
{
    private static $_directories = [
        'controller/', 
        'model/entity/', 
        'model/manager/', 
        'view/frontView/',
        'view/backView/',
        'config/'];

    public function __construct()
    {
        spl_autoload_register([__CLASS__, 'classLoader']);
        
    }

    public static function classLoader($className)
    {
        
        foreach (self::$_directories as $directory) {
            $nameSpace = explode('\\', $className);

            $className = end($nameSpace);

            $fileName = $directory . $className . '.php';
            if (file_exists($fileName)) {
                include_once $fileName;
            }
        }
    }
}