<?php

/**
 * This file contains BackAddPostController class
 */
namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for manage action on add post page
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackAddPostController extends BackPostController
{
    /**
     * Action buttons on add post page
     * 
     * @return void
     */
    public function addPostAction()
    {
        $backImageController = new \controller\BackPImgController;
        $var = new \config\GlobalVar;

        if ($var->issetPost('addPost')) {
                    
            if ($var->issetGet('id')) { 
                $form = $this -> dataInputPost($var->get('id'));
                
            } else {
                $form = $this -> dataInputPost();   
            } 
            $form['published'] = 'TRUE';
            $this -> addPostView($form);
            return;

        } elseif ($var->issetPost('preview')) {
            if ($var->issetGet('id')) {
                $form = $this -> dataInputPost($var->get('id'));
            } else {
                $form = $this -> dataInputPost();
            }
            $this -> previewPost($form);
            return;

        } elseif ($var->issetPost('notPublished')) {  
            if ($var->issetGet('id')) {
                $form = $this -> dataInputPost($var->get('id'));
            } else {
                $form = $this -> dataInputPost();
            }
            $form['published'] = 'FALSE';
            $this -> addPostView($form);
            return;

        } elseif ($var->issetPost('imgChange')) {
            $backImageController -> imgChange();
            return;

        } elseif ($var->issetGet('id')) {
            if ($var->issetSession('previewPost')) {
                $updatePost = $var->session('previewPost');
                
            } else {
                $updatePost = $this  -> updatePost($var->get('id'));
                $var->setSession('previewPost', $updatePost);
            }
            $this  -> addPostView($form=null, null, $updatePost);
            return;
            
        } elseif ($var->issetSession('previewPost')) {
            $previewPost = $var->session('previewPost');
            $this  -> addPostView($form=null, $msg=null, $previewPost);
            return;
            
        } else {
            if ($var->issetSession('addPostMsg')) {
                $this  -> addPostView(null, $var->session('addPostMsg'));
                $var->unsetSession('addPostMsg');
                return;
            } 
            $this -> addPostView();
            return;   
        }
    }
}