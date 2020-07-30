<?php

class Router 
{ 

    public function runPage($get)
    {
        if ($get == 'home') {

            $frontController = new FrontController;
            $frontController -> homePage();

            //if ()

        }
        elseif ($get == 'listposts') {

            $frontController = new FrontController;
            $frontController -> listPostsView(); 
            
        }
    }

    public function runSendMessage(array $form)
    {
        $frontController = new FrontController;
        $frontController -> sendMessage($form);
    }
}