<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
require 'config/config.php';
$autoloader = new config\Autoloader;

session_start();

try 
{
    $router = new config\Router;
        
    if (isset($_GET['p'])) {
        
        $msg = $router -> runFrontPage($_GET['p']);
    
    } elseif (isset($_GET['admin'])) {
        
        $router -> runBackPage($_GET['admin']);

    } else {
        
        $frontController = new \controller\FrontController;
        $frontController -> homePage();
    }   
}

catch (Exception $e)
{
    echo $e -> getMessage();
}

