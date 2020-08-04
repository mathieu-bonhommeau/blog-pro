<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
require 'config/config.php';
$autoloader = new Autoloader;

session_start();

try 
{
    $router = new Router;

    if (isset($_SESSION['msgOk']) && $_SESSION['msgOk'] == 'ok')
    {
        unset($_SESSION['msgOk']);
        $frontController = new FrontController;
        $frontController -> homePage();
        
    }

    elseif (isset($_GET['p'])) {
        $msgOk = $router -> runPage($_GET['p']);
        $_SESSION['msgOk'] = $msgOk;
        
    } else {
        unset($_SESSION['msgOk']);
        $frontController = new FrontController;
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