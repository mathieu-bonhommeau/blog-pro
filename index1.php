<?php

require 'vendor/autoload.php';
require 'config/Autoloader.php';
require 'config/config.php';
$autoloader = new Autoloader;



try 
{
    $router = new Router;

    if (isset($_GET['p'])) {
        $router -> runPage($_GET['p']);

        if (isset($_POST['submitMessage'])) {
            if (!empty($_POST['inputName']) 
                && !empty($_POST['inputFirstName']) 
                && !empty($_POST['inputEmail']) 
                && !empty($_POST['inputMessage'])
            ) {
                $form = array('inputName' => $_POST['inputName'], 
                              'inputFirstName' => $_POST['inputFirstName'], 
                              'inputEmail' => $_POST['inputEmail'], 
                              'inputMessage' => $_POST['inputMessage']
                );
                $msg = $router -> runSendMessage($form);
                echo $msg;
            } else {
                throw new Exception('OUPS !!! Un des champs est vide');
            }
        }
    } else {

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