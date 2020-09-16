<?php

/**
 * This file contains FrontController class
 */
namespace controller;

/**
 * Class for get datas and send it back to front views
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class FrontController extends Controller
{
    /**
     * Retrieves and send data to view Homepage
     * 
     * @param string $msg Email message
     * 
     * @return void
     */
    public function homePage($msg=null)
    {

        $postManager = new \model\PostManager;
        $posts = $postManager -> getHomePosts(3);
        $view = new \view\View;

        $data = array(
            'posts' => $posts,
            'msg' => $msg,
            'user' => $this->user 
        );
        $page = 'frontView/homeView.twig';
        $view -> displayPage($data, $page);

    }

    /**
     * Test inputs in form for send email on homepage
     * 
     * @return mixed array $form if test ok
     *               string EMPTY_FIELDS if test no ok
     */
    public function testInputMessage()
    {
        $var = new \config\GlobalVar;

        if ($var->noEmptyPost('inputName')
            && $var->noEmptyPost('inputFirstName') 
            && $var->noEmptyPost('inputEmail') 
            && $var->noEmptyPost('inputMessage')
        ) {
            $form = array('inputName' => $var->post('inputName'), 
                    'inputFirstName' => $var->post('inputFirstName'), 
                    'inputEmail' => $var->post('inputEmail'), 
                    'inputMessage' => $var->post('inputMessage')       
            );
            return $form;
        }
        return EMPTY_FIELDS;
    }

    /**
     * Sends a email to website support with email form on homepage
     * 
     * @param array $form Array with form email inputs
     * 
     * @return string Email ok or not
     */
    public function runSendMessage($form)
    {
        $controller = new \controller\Controller;
        if ($form == EMPTY_FIELDS) {
            return EMPTY_FIELDS;
        }
        $controller -> sendMessage($form, SUPPORT_EMAIL);
        $msg = $controller -> msg();
        return $msg;
    }

    /**
     * Retrieves and send data for display a list 
     * with all the posts on listposts view
     * 
     * @return void
     */
    public function listPosts()
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getPosts();
        $view = new \view\View;

        $data = array('posts' => $posts,'user' => $this->user);
        $page = 'frontView/listPostView.twig';
        $view -> displayPage($data, $page);
    }

    /**
     * Retrieves and send data for display one post on post alone view
     * 
     * @param int    $postId Id of post
     * @param string $msg    Message when visitor send a comment 
     * 
     * @return void
     */
    public function post($postId, $msg=null)
    {
        $var = new \config\GlobalVar;
        $view = new \view\View;

        $backManageComment = null;

        if ($var->issetGet('c')) {
            $backManageComment = $var->get('c');
        } 
        $postManager = new \model\PostManager;
        $dataPost = $postManager -> getPost($postId);

        if (!$dataPost) {  
            throw new \Exception(PAGE_NOT_EXIST);  
        }

        $post = new \model\Post($dataPost);
        
        if ($post->published() == 'FALSE' && $backManageComment != 'valid'
            && $backManageComment != 'ok' && $backManageComment != 'moderate'
            && $backManageComment != 'list'
        ) {
            throw new \Exception(PAGE_NOT_EXIST);
        } 

        $commentManager = new \model\CommentManager;
        $dataComment = $commentManager -> getComments($postId);
        $nbrComments = $commentManager -> nbrComments($postId, 'TRUE');

        $data = array('post' => $post, 'comments' => $dataComment,
            'nbrComments' => $nbrComments['COUNT(*)'], 'commentMsg' => $msg, 
            'user' => $this->user, 'backManageComment' => $backManageComment
        );
        $page = 'frontView/postView.twig';
        $view -> displayPage($data, $page);   
    }

    /**
     * Add a comment on a post
     * 
     * @param array $form Array with inputs comment form
     * 
     * @return string Message 
     */
    public function addNewComment(array $form)
    {
        $comment = new \model\Comment($form);

        $commentManager = new \model\CommentManager;
        $affectedLines = $commentManager -> addComment($comment);

        if ($affectedLines == 1) {
            return WAIT_VALID_COMMENT;
        } else {
            return MSG_NO_OK;
        }
    }

    /**
     * Valid comment if get variable 'cid'  exists
     * 
     * @return void
     */
    public function validComment()
    {
        $var = new \config\GlobalVar;
        $backCommentController = new \controller\BackCommentController;

        if ($var->issetGet('cid')) {      
            $backCommentController -> updateComment($var->get('cid'));
            return;
        }
    }

    /**
     * Test input comment in form on post alone page
     * 
     * @param bool  $valid    Comment is valid or not
     * @param mixed $moderate int if $moderate = 1 Moderate comment
     *                        else $moderate = null
     * 
     * @return string Message
     */
    public function testInputComment($valid, $moderate=null)
    {
        $var = new \config\GlobalVar;
        $frontController = new \controller\FrontController;

        $userId = null;
        $userType = null;

        if ($var->issetSession('user')) {
            $userId = $var->session('user')->userId();
        } 

        if ($moderate != null) {
            $userType = $var->session('user')->type() . ' : ';
        }

        if ($var->noEmptyPost('nameVisitor') 
            && $var->noEmptyPost('emailVisitor') 
            && $var->noEmptyPost('content')
        ) {                           
            $form = array(
                'nameVisitor' => $userType . $var->post('nameVisitor'),
                'emailVisitor' => $var->post('emailVisitor'),
                'content' => $var->post('content'),
                'validComment' => $valid,
                'user_id' => $userId,
                'post_id' =>$var->get('id')
            );           
            return $this -> addNewComment($form);              
        } 
        return EMPTY_FIELDS;             
    }

    /**
     * Display connect page
     * 
     * @param string $msg Message for connect is ok or not
     * 
     * @return void
     */
    public function connect($msg=null)
    {
        $view = new \view\View;

        $data = array('user' => $this->user,'msg' => $msg);
        $page = 'frontView/connectView.twig';
        $view -> displayPage($data, $page);
    }

    /**
     * Test inputs in connect form
     * 
     * @return mixed 
     */
    public function testInputConnect()
    {
        $var = new \config\GlobalVar;

        if ($var->noEmptyPost('inputPseudoConnect') 
            && $var->noEmptyPost('inputPasswordConnect')
        ) {
            $msgConnect = $this -> verifyUser(
                $var->post('inputPseudoConnect'), 
                $var->post('inputPasswordConnect')    
            );
            return $msgConnect;
            
        } else {

            $msgConnect = EMPTY_FIELDS;
            $this -> connect($msgConnect);
            return;
        }
    }

    /**
     * Verify if user exists with pseudo and password
     * Connect the user 
     * 
     * @param string $pseudo   Pseudo of user
     * @param string $password Password of user 
     * 
     * @return mixed Void if connect is ok
     *               Message string if connect is no ok
     */
    public function verifyUser($pseudo, $password)
    {
        $var = new \config\GlobalVar;

        $userManager = new \model\UserManager;
        $data = $userManager -> getUser($pseudo);
        
        if ($data) {
            $user = new \model\User($data);
        } else {
            return  USER_NO_OK; 
        }
        
        if (($var->issetGet('admin') != true 
            || $var->get('admin') != 'adduser') 
            && password_verify(
                $password, $user->password()
            )         
        ) {
            
            $var -> setSession('user', $user);
            $var -> unsetSession('msg');
            header('Location: index.php?p=home');
            exit();
        }

        if (($var->get('admin') == 'adduser' && $password == $user->password())
        ) {
            $var -> setSession('user', $user);
            $var -> unsetSession('msg');
            header('Location: index.php?p=home');
            exit();
        } 
             
    }
}