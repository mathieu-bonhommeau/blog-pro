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
                $var -> setSession('msg', $msg);
                header('Location: index.php?p=home#signup'); 
                return;
            } 
            if ($var->issetSession('msg')) {
                $msg = $var->session('msg');
                $frontController -> homePage($msg);
                $var->unsetSession('msg');
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

            } elseif ($var->issetPost('submitComment')) {
                
                $msg = $frontController -> testInputComment('FALSE', null);
                $var -> setSession('commentMsg', $msg);
                header(
                    'Location: index.php?p=post&id=' 
                    . $var->get('id') . '#comments'
                );
                exit();
            
            } elseif ($var->issetPost('submitModerateComment')) {

                $msg = $frontController -> testInputComment('TRUE', 1);
                $var -> setSession('msg', $msg);
                header('Location: index.php?p=post&id=' . $var->get('id') . '&c=ok');
                exit();

            } elseif ($var->issetPost('publishedPost')) {
                
                $backPostController = new \controller\BackPostController;
                $backPostController -> publishedPost($var->get('id'));
                return;
            } 
                
            if (isset($_SESSION['commentMsg'])) {
                $frontController -> postView(
                    $var->get('id'), $var->session('commentMsg')
                );
                $var -> unsetSession('commentMsg');
                return;
            } 

            $frontController -> postView($var->get('id'));
            return;

        } elseif ($get == 'connect') {
            
            $frontController = new \controller\FrontController;

            if ($var->issetPost('submitConnect')) {
                
                $msgConnect = $frontController -> testInputConnect();
                $var -> setSession('msgConnect', $msgConnect);    
                header('Location: index.php?p=connect');
                exit();
            } 
            
            if ($var->issetSession('msgConnect')) {

                $frontController -> connectView($var->session('msgConnect'));
                $var -> unsetSession('msgConnect');
                return;
            } 
            $frontController -> connectView();
               
        } elseif ($get == 'disconnect') {

            $var -> unsetSession('user');
            header('Location: index.php');
        }

        throw new \Exception(PAGE_NOT_EXIST);
    }  
}