<?php

/**
 * This file contains RouterFront class
 */
namespace config;

/**
 * Class for routing on front pages
 * 
 * PHP version 7.3.12
 * 
 * @category  Config
 * @package   \config
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class RouterFront 
{
    /**
     * Routing on front pages
     * 
     * @param string $get Index $_GET
     * 
     * @return mixed
     */
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
                
            if ($var->issetSession('commentMsg')) {
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
            return;
               
        } elseif ($get == 'disconnect') {

            $var -> unsetSession('user');
            header('Location: index.php');
            exit();
        }

        throw new \Exception(PAGE_NOT_EXIST);
    }  
}