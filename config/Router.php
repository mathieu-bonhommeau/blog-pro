<?php

namespace config;

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
        
                $frontController = new \controller\FrontController;
                $frontController -> homePage($msg);

                if ($msg == MSG_OK) {
                    return $get = 'ok';
                }

            }
            
        }

        elseif ($get == 'listposts') {

            $frontController = new \controller\FrontController;
            $frontController -> listPostsView(); 
            
        }

        elseif ($get == 'post') {

            if (isset($_GET['id'])) {
               
                $frontController = new \controller\FrontController;
                $frontController -> postView($_GET['id']); 

                if (isset($_POST['submitComment'])) {
                    if (!empty($_POST['nameVisitor']) 
                        && !empty($_POST['emailVisitor']) 
                        && !empty($_POST['content'])
                    ) {
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                        } else {
                            $user_id = null;
                        }
                        
                        $form = array(
                            'nameVisitor' => $_POST['nameVisitor'],
                            'emailVisitor' => $_POST['emailVisitor'],
                            'content' => $_POST['content'],
                            'user_id' => $user_id,
                            'post_id' =>$_GET['id']
                        );

                        $comment = new \model\Comment($form);

                        $frontController -> addNewComment($form);

                    } else {
                        $msg = EMPTY_FIELDS;
                    }
                }
                dump($comment);

            } else {
                throw new Exception('Cette page n\'existe pas');
            }
        }
    }

    public function runSendMessage(array $form)
    {
        $frontController = new \controller\FrontController;
        $frontController -> sendMessage($form);
        $msg = $frontController -> msg();
        return $msg;
    }
}