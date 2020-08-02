<?php

class Router 
{ 

    public function runPage($get)
    {
        if ($get == 'nok') {
                
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
                        $msg = $this -> runSendMessage($form);
                    } else {
                        $msg = EMPTY_FIELDS;
                    }
                }

            $frontController = new FrontController;
            $frontController -> homePageMsg($msg);
        }

        elseif ($get == 'ok') {

            $msg = MSG_OK;
            $frontController = new FrontController;
            $frontController -> homePageMsg($msg);
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
        $msg = $frontController -> msg();
        return $msg;
    }
}