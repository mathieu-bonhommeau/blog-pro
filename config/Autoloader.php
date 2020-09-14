<?php

/**
 * This file contains Autoloader class
 */
namespace config;

/**
 * Class for autoloader of class 
 */
class Autoloader 
{
    private static $_directories = [
        'controller/', 
        'model/entity/', 
        'model/manager/', 
        'view/frontView/',
        'view/backView/',
        'config/'];

    /**
     * __construct Init 
     * 
     * @return void
     */
    public function __construct()
    {
        spl_autoload_register([__CLASS__, 'classLoader']);
        
    }

    /**
     * Test class
     * 
     * @param string $className Name of class
     * 
     * @return void
     */
    public static function classLoader($className)
    {
        foreach (self::$_directories as $directory) {
            $nameSpace = explode('\\', $className);

            $className = end($nameSpace);

            $fileName = $directory . $className . '.php';
            if (file_exists($fileName)) {
                include $fileName;
            }
        }
    }
}