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
    $var = new config\GlobalVar;
        
    if ($var->issetGet('p')) {
        
        $msg = $routerFront -> runFrontPage($var->get('p'));
    
    } elseif ($var->issetGet('admin')) {
        
        $routerBack -> runBackPage($var->get('admin'));

    } else {
    
        $frontController = new \controller\FrontController;
        $frontController -> homePage();
    }   
}

catch (Exception $e)
{
    $controller = new controller\controller;
    $controller -> errorView($e -> getMessage());
}

