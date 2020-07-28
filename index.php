<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
$autoloader = new Autoloader;



try 
{
    $router = new Router;

    if (isset($_GET['p'])) {
        $router -> run($_GET['p']);
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