<?php

/**
 * This file contains Autoloader class
 */
namespace config;

/**
 * Class for autoload all the class of the project
 * 
 * PHP version 7.3.12
 * 
 * @category  Config
 * @package   \config
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Autoloader
{
    private static $_directories = [
        'controller/', 
        'model/entity/', 
        'model/manager/',
        'view/', 
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
     * Loop for find the corresponding class in the project
     * Test if the file exist
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