<?php

/**
 * This file contains BackPostController class
 */
namespace controller;

/**
 * Class for get posts data and send it back to views
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackPostController extends BackController
{
    /**
     * Retrives and send data to listposts page
     * 
     * @return void 
     */
    public function backListPosts()
    {
        $var = new \config\GlobalVar;
        $postManager = new \model\PostManager;
        $view = new \view\View;
        
        if ($var->session('user')->type() == 'administrator') {
            $posts = $postManager -> getPosts();
        } elseif ($var->session('user')->type() == 'author') {
            $posts = $postManager -> getUserPosts($var->session('user')->userId());
        }
        $data = array('user' => $this->user,'posts' => $posts);
        $page = 'backView/backListPostView.twig';
        $view -> displayPage($data, $page);
    }

    /**
     * Call the right method for action buttons on list post page 
     * 
     * @return void
     */
    public function backListPostsAction()
    {
        $var = new \config\GlobalVar;
        $backAddPostController = new \controller\BackAddPostController;

        if ($var->issetGet('published')) {
            $backAddPostController -> publishedPost($var->get('published'));
            return; 
        }   
        if ($var->issetGet('delete')) { 
            if ($var->issetPost('validDelete')) {
                $this -> deletePost($var->get('delete'));
                return;

            } elseif ($var->issetPost('cancelDelete')) {    
                header('Location: index.php?admin=post');
                exit();  

            } else {
                $this -> deletePostPage($var->get('delete'));
                return;  
            }    
        }
        $this -> backListPosts();     
    }

    /**
     * Retrieves and send data to delete post page
     * 
     * @param int $postId Id of post
     * 
     * @return void
     */
    public function deletePostPage($postId)
    {
        $postManager = new \model\PostManager;
        $view = new \view\View;

        $dataPost = $postManager -> getPost($postId);

        if ($dataPost == false) {
            throw new \Exception(PAGE_NOT_EXIST);

        } else {
            $post = new \model\Post($dataPost);

            $commentManager = new \model\CommentManager;
            $dataComment = $commentManager -> getComments($postId, 'TRUE');
            $nbrComments = $commentManager -> nbrComments($postId, 'TRUE');

            $data = array(
                'post' => $post,
                'comments' => $dataComment,
                'nbrComments' => $nbrComments['COUNT(*)'],
                'user' => $this->user
            );
            $page = 'backView/deletePostView.twig';
            $view -> displayPage($data, $page);
        }      
    }

    /**
     * Delete post
     * 
     * @param int $postId Id of post
     * 
     * @return void
     */
    public function deletePost($postId)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($postId);
        $post = new \model\Post($data);

        $commentManager = new \model\CommentManager;
        $commentManager->deletePostComments($postId);
        
        $affectedLines = $postManager->deletePost($postId);

        if ($affectedLines == 1) {
            unlink(POST_IMG_DIRECTORY . basename($post->picture()));
            header('Location: index.php?admin=post');

        } else {
            throw new \Exception(POST_NO_SUP);
        }
    }

    /**
     * This method delete post session if it exist 
     * and delete post picture if picture exist in 'postImg' folder
     * 
     * @param string $name Index of the session
     * 
     * @return void
     */
    public function deleteSession($name) 
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession($name) 
            && (file_exists(
                $var->session($name) -> picture()
            ))
        ) {
            $postManager = new \model\PostManager;
            $result = $postManager -> getPostImg(
                basename($var->session($name) -> picture())
            );
            if ($result == 0) {
                unlink($var->session($name) -> picture());
            }
            $var->unsetSession($name);
            return; 
        }
        if ($var->issetSession($name) 
            && (!file_exists($var->session($name) -> picture()))
        ) {
            $var->unsetSession($name);
            return;
        }
        return;      
        
    }

    /**
     * Verify if tmp folder exist
     * 
     * @return void
     */
    public function verifTmpFolder()
    {
        if (!file_exists('tmp/')) {
            mkdir('tmp/');
        }
    }
}