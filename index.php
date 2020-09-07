<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
require 'config/config.php';
$autoloader = new config\Autoloader;

session_start();

try 
{
    $routerFront = new config\RouterFront;
    $routerBack = new config\RouterBack;
        
    if (isset($_GET['p'])) {
        
        $msg = $routerFront -> runFrontPage($_GET['p']);
    
    } elseif (isset($_GET['admin'])) {
        
        $routerBack -> runBackPage($_GET['admin']);

    } else {
    
        $frontController = new \controller\FrontController;
        $frontController -> homePage();
    }   
}

catch (Exception $e)
{
    echo $e -> getMessage();
}

