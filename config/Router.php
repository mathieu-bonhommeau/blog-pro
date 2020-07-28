<?php

class Router 
{ 

    public function run($route)
    {
        if ($route == 'home') {

            $frontController = new FrontController;
            $frontController -> homeView();

        }
        elseif ($route == 'listposts') {

            $frontController = new FrontController;
            $frontController -> listPostsView(); 
            
        }
    }

    //public function get
}