<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackAddPostController extends BackPostController
{
    public function addPostAction()
    {
        $backImageController = new \controller\BackPImgController;

        if (isset($_POST['addPost'])) {
                    
            if (isset($_GET['id'])) { 
                $form = $this -> dataInputPost($_GET['id']);
                
            } else {
                $form = $this -> dataInputPost();   
            } 
            $form['published'] = 'TRUE';
            $this -> addPostView($form);
            return;

        } elseif (isset($_POST['preview'])) {
            if (isset($_GET['id'])) {
                $form = $this -> dataInputPost($_GET['id']);
            } else {
                $form = $this -> dataInputPost();
            }
            $this -> previewPost($form);
            return;

        } elseif (isset($_POST['notPublished'])) {  
            if (isset($_GET['id'])) {
                $form = $this -> dataInputPost($_GET['id']);
            } else {
                $form = $this -> dataInputPost();
            }
            $form['published'] = 'FALSE';
            $this -> addPostView($form);
            return;

        } elseif (isset($_POST['imgChange'])) {
            $backImageController -> imgChange();
            return;

        } elseif (isset($_GET['id'])) {
            if (isset($_SESSION['previewPost'])) {
                $updatePost = $_SESSION['previewPost'];
                
            } else {
                $updatePost = $this  -> updatePost($_GET['id']);
                $_SESSION['previewPost'] = $updatePost;
            }
            $this  -> addPostView($form=null, null, $updatePost);
            return;
            
        } elseif (isset($_SESSION['previewPost'])) {
            $previewPost = $_SESSION['previewPost'];
            $this  -> addPostView($form=null, $msg=null, $previewPost);
            return;
            
        } else {
            if (isset($_SESSION['addPostMsg'])) {
                $this  -> addPostView(null, $_SESSION['addPostMsg']);
                unset($_SESSION['addPostMsg']);
                return;
            } 
            $this -> addPostView();
            return;   
        }
    }
}