<?php

/**
 * This file contains BackPostController class
 */
namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

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
        
        if ($var->session('user')->type() == 'administrator') {
            $posts = $postManager -> getPosts();
        } elseif ($var->session('user')->type() == 'author') {
            $posts = $postManager -> getUserPosts($var->session('user')->userId());
        }

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backListPostView.twig', array(
                'user' => $this->user,
                'posts' => $posts 
            )
        );
    }

    /**
     * Call the right method for action buttons on list post page 
     * 
     * @return void
     */
    public function backListPostsAction()
    {
        $var = new \config\GlobalVar;

        if ($var->issetGet('published')) {
            $this -> publishedPost($var->get('published'));
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
                $this -> deleteView($var->get('delete'));
                return;  
            }    
        }
        $this -> backListPosts();     
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
    public function addPostView(
        array $form=null, 
        $msg=null, 
        \model\Post $postPreview=null
    ) { 
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
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'backView/addPostView.twig', array(
                'user' => $this->user,
                'msg' => $msg,
                'postPreview' => $postPreview  
            )
        );
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
        
        $newPost = new \model\Post($form);
        $newPost -> setLastDateModif(time());
        $newPost -> setAuthorName($var->session('user')->authorName());

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView\postPreview.twig', array(
                'user' => $this->user,
                'newPost' => $newPost    
            )
        );
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

    /**
     * Retrieves and send data to delete post page
     * 
     * @param int $postId Id of post
     * 
     * @return void
     */
    public function deleteView($postId)
    {
        $postManager = new \model\PostManager;
        $dataPost = $postManager -> getPost($postId);

        if ($dataPost == false) {
            throw new \Exception(PAGE_NOT_EXIST);

        } else {
            $post = new \model\Post($dataPost);

            $commentManager = new \model\CommentManager;
            $dataComment = $commentManager -> getComments($postId, 'TRUE');
            $nbrComments = $commentManager -> nbrComments($postId, 'TRUE');

            $this->twigInit();
            $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
            $this->twig->addExtension(new Twig_Extensions_Extension_Text());

            echo $this->twig->render(
                'backView/deletePostView.twig', array(
                    'post' => $post,
                    'comments' => $dataComment,
                    'nbrComments' => $nbrComments['COUNT(*)'],
                    'user' => $this->user
                )
            );
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
     * Delete post session
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