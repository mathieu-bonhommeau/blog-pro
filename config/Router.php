<?php

class Router 
{ 

    public function runPage($get)
    {
        if ($get == 'home') {
            
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
        
                $frontController = new FrontController;
                $frontController -> homePageMsg($msg);

                if ($msg == MSG_OK) {
                    return $get = 'ok';
                }

            }
            
        }

        elseif ($get == 'listposts') {

            $frontController = new FrontController;
            $frontController -> listPostsView(); 
            
        }

        elseif ($get == 'post') {

            if (isset($_GET['id'])) {
               
                $frontController = new FrontController;
                $frontController -> postView($_GET['id']); 

                if (isset($_POST['submitComment'])) {
                    if (!empty($_POST['inputVisitorName']) 
                        && !empty($_POST['inputEmailVisitor']) 
                        && !empty($_POST['inputComment'])
                    ) {
                        $form = array(
                            'inputVisitorName' => $_POST['inputVisitorName'],
                            'inputEmailVisitor' => $_POST['inputEmailVisitor'],
                            'inputComment' => $_POST['inputComment'],
                        );

                        $frontController -> addNewComment($form);

                    } else {
                        $msg = EMPTY_FIELDS;
                    }
                }

            } else {
                throw new Exception('Cette page n\'existe pas');
            }
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