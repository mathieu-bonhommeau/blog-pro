<?php

/**
 * This file contains BackAddPostController class
 */
namespace controller;

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
            $this -> addPost($form);
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
            $this -> addPost($form);
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
            $this  -> addPost($form=null, null, $updatePost);
            return;
            
        } elseif ($var->issetSession('previewPost')) {
            $previewPost = $var->session('previewPost');
            $this  -> addPost($form=null, $msg=null, $previewPost);
            return;
            
        } else {
            if ($var->issetSession('addPostMsg')) {
                $this  -> addPost(null, $var->session('addPostMsg'));
                $var->unsetSession('addPostMsg');
                return;
            } 
            $this -> addPost();
            return;   
        }
    }

    /**
     * Retrives and send data to addPost page
     * 
     * @param array  $form        If update post 
     * @param string $msg         Message
     * @param Post   $postpreview Post object for manage preview feature
     * 
     * @return void
     */
    public function addPost(
        array $form=null, 
        $msg=null, 
        \model\Post $postPreview=null
    ) { 
        $view = new \view\View;

        if ($form != null) {
            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            
            if ($newPost->postId() == null) {
                $result = $postManager -> addPost($newPost);
                $this -> resultPost($result[0], $result[1]);

            } else {
                
                $result = $postManager -> updatePost($newPost);
                
                $this -> resultPost($result, $newPost->postId());
            }
        }
        $data = array('user' => $this->user,'msg' => $msg,
            'postPreview' => $postPreview  
        );
        $page = 'backView/addPostView.twig';
        $view -> displayPage($data, $page);
    }

    /**
     * Manage results of add post
     * 
     * @param int $affectedLines Number of affected lines 
     *                           when add a new post or update post
     * @param int $postId        Id of post
     * 
     * @return void
     */
    public function resultPost($affectedLines, $postId) 
    {
        $postManager = new \model\PostManager;
        $var = new \config\GlobalVar;

        if ($affectedLines != 1) {
            $var->setSession('addPostMsg', POST_NO_OK);
            header('Location: index.php?admin=addpost');
            exit(); 
        }

        $data = $postManager -> getPost($postId);
        $newPost = new \model\Post($data);
            
        if ($newPost->published() != 'TRUE') {
            $var->setSession('addPostMsg', MSG_SAVE);
            $this -> deleteSession('previewPost');
            header('Location: index.php?admin=addpost');
            exit();
        }

        if (($var->issetSession('previewPost') 
            && $var->issetSession('oldImage')) && (basename(
                $var->session('previewPost')->picture()
            )  != $var->session('oldImage'))
        ) {
            unlink(POST_IMG_DIRECTORY . $var->session('oldImage'));  
        }
        $this -> deleteSession('previewPost');
        header('Location: index.php?p=post&id=' . $newPost->postId());
        exit();     
    }

    /**
     * Manage preview postr feature
     * 
     * @param array $form Inputs of addpost form in add post page for preview feature
     * 
     * @return void
     */
    public function previewPost(array $form)
    {
        $var = new \config\GlobalVar;
        $view = new \view\View;
        
        $newPost = new \model\Post($form);
        $newPost -> setLastDateModif(time());
        $newPost -> setAuthorName($var->session('user')->authorName());

        $data = array('user' => $this->user,'newPost' => $newPost);
        $page = 'backView\postPreview.twig';
        $view -> displayPage($data, $page);
        $var->setSession('previewPost', $newPost);
    }

    /**
     * If session 'previewpost' exists, 
     * this method give these values at addpost form inputs
     * 
     * @return void
     */
    public function inputPostTest() 
    {
        $var = new \config\GlobalVar;

        if (($var->emptyPost('titlePost') 
            && $var->emptyPost('chapoPost') 
            && $var->emptyPost('contentPost')) 
            && ($var->issetSession('previewPost'))
        ) {
            $var->setPost('titlePost', $var->session('previewPost')->title());
            $var->setPost('chapoPost', $var->session('previewPost')->chapo());
            $var->setPost('contentPost', $var->session('previewPost')->content());  
        }
        return;
    }

    /**
     * Test inputs in add post form on addpost page
     * 
     * @param int $postId Id of post
     * 
     * @return array $form Array with inputs addpost form
     */
    public function dataInputPost($postId=null)
    {
        $var = new \config\GlobalVar;
        $backImageController = new \controller\BackPImgController;

        $this -> inputPostTest();

        if ($var->noEmptyPost('titlePost')
            && $var->noEmptyPost('chapoPost')
            && $var->noEmptyPost('contentPost')
        ) {
            if (empty($_FILES['imgPost']['name'])) {
                $path = $backImageController->managePostImage();
    
            } else {
                $path =  $backImageController -> uploadFile($_FILES['imgPost']);  
            }
            $form = array(
                'id' => $postId,
                'title' => $var->post('titlePost'),
                'chapo' => $var->post('chapoPost'),
                'content' => $var->post('contentPost'),'picture' => $path,
                'published' => 'FALSE'   
            );
            return $form;

        }
        $var->setSession('addPostMsg', EMPTY_FIELDS);
        header('Location: index.php?admin=addpost');
    }

    /**
     * Publish post
     * 
     * @param int $postId Id of post
     * 
     * @return void
     */
    public function publishedPost($postId) 
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($postId);
        if ($data) {
            $post = new \model\Post($data);
            $post -> setPublished('TRUE');
            
            $affectedLine = $postManager -> updatePost($post);
            
            if ($affectedLine == 1 && $_GET['c'] == 'valid') {
                
                header('Location: index.php?p=post&id=' . $postId);

            } elseif ($affectedLine == 1 && $_GET['c'] != 'valid') {
                
                header('Location: index.php?admin=post');
            }
            throw new \Exception(POST_NO_OK); 
            return;   
        } 
        throw new \Exception(POST_NO_EXIST);   
    }

    /**
     * Update a post
     * 
     * @param int $postId Id of post
     */
    public function updatePost($postId)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($postId);
        
        if ($data) {
            $post = new \model\Post($data);
            
            $_SESSION['oldImage'] = basename($post->picture());

            if ($post->picture() != null 
                && file_exists(POST_IMG_DIRECTORY . $post->picture())
            ) {
                $this -> verifTmpFolder();
                copy(
                    POST_IMG_DIRECTORY . $post->picture(), 'tmp/' 
                    . 'tmp' . $post->picture()
                );
                $post->setPicture('tmp/' . 'tmp' . $post->picture());
            }
            return $post;
        } 
        throw new \Exception(POST_NO_EXIST);  
    }
}