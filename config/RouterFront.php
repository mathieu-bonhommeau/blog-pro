<?php

namespace config;

class RouterFront 
{ 
    public function runFrontPage($get)
    {
        $var = new \config\GlobalVar;

        if ($get == 'home') {

            $frontController = new \controller\FrontController;

            if ($var->issetPost('submitMessage')) {
                $form = $frontController -> testInputMessage();   
                $msg = $frontController -> runSendMessage($form); 
                $_SESSION['msg'] = $msg;
                header('Location: index.php?p=home#signup'); 
                return;
            } 
            if (isset($_SESSION['msg'])) {
                $msg = $_SESSION['msg'];
                $frontController -> homePage($msg);
                unset($_SESSION['msg']);
                return;
            } 
            $frontController -> homePage();
            return;   
            
        } elseif ($get == 'listposts') {

            $frontController = new \controller\FrontController;
            $frontController -> listPostsView(); 
            return;
            
        } elseif ($get == 'post' && $var->issetGet('id')) {

            $frontController = new \controller\FrontController;

            //$getSubmitComment = filter_input(INPUT_POST, 'submitComment');

            if ($var->issetGet('c') 
                && ($var->get('c') == 'ok' || $var->get('c') == 'moderate')
            ) {
                $frontController -> validComment();
                $frontController -> postView($var->get('id'));
                return;

            } elseif ($var->issetGet('submitComment')) {
                
                $msg = $frontController -> testInputComment('FALSE', null);
                $_SESSION['commentMsg'] = $msg;
                header(
                    'Location: index.php?p=post&id=' 
                    . $var->get('id') . '#comments'
                );
                exit();
            
            } elseif (isset($_POST['submitModerateComment'])) {

                $msg = $frontController -> testInputComment('TRUE', 1);
                $_SESSION['commentMsg'] = $msg;
                header('Location: index.php?p=post&id=' . $_GET['id'] . '&c=ok');
                exit();

            } elseif (isset($_POST['publishedPost'])) {
                
                $backPostController = new \controller\BackPostController;
                $backPostController -> publishedPost($_GET['id']);
                return;
            } 
                
            if (isset($_SESSION['commentMsg'])) {
                $frontController -> postView(
                    $_GET['id'], $_SESSION['commentMsg']
                );
                unset($_SESSION['commentMsg']);
                return;
            } 

            $frontController -> postView($_GET['id']);
            return;

        } elseif ($get == 'connect') {
            
            $frontController = new \controller\FrontController;

            if (isset($_POST['submitConnect'])) {
                
                $msgConnect = $frontController -> testInputConnect();    
                $_SESSION['msgConnect'] = $msgConnect;
                header('Location: index.php?p=connect');
                exit();
            } 
            
            if (isset($_SESSION['msgConnect'])) {

                $frontController -> connectView($_SESSION['msgConnect']);
                unset($_SESSION['msgConnect']);
                return;
            } 
            $frontController -> connectView();
               
        } elseif ($get == 'disconnect') {

            unset($_SESSION['user']);
            header('Location: index.php');
        }

        throw new \Exception(PAGE_NOT_EXIST);
    }  
}