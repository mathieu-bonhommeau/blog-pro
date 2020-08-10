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
        
        $msg = $router -> runPage($_GET['p']);
        
    } else {
        
        $frontController = new \controller\FrontController;
        $frontController -> homePage();

    }
    


    /*if (isset($_GET['p'])) {

        if ($_GET['p'] == 'home') {

            
            
        } elseif ($_GET['p'] == 'listposts') {
            echo $twig -> render('frontView/listPostView.twig');
        } 
    } else {
        echo $twig->render('frontView/homeView.twig');
    }*/
}
catch (Exception $e)
{
    echo $e -> getMessage();
}

?>