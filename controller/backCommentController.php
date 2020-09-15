<?php

/**
 * This file contains BackCommentController class
 */
namespace controller;

use Exception;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for get comments data and send it back to views
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackCommentController extends BackController
{
    /**
     * Retrieves and send data to valid comment page
     * 
     * @return void
     */
    public function validComment()
    {
        $commentManager = new \model\CommentManager;
        $comments = $commentManager -> getAllComments('FALSE');

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/validCommentView.twig', array(
                'user' => $this->user,
                'comments' => $comments 
            )
        );
    }

    /**
     * Update comment - Comment change to valid
     * 
     * @param int $commentId Id of comment
     * 
     * @return Number of affected lines
     */
    public function updateComment($commentId)
    {
        $commentManager = new \model\CommentManager;
        $affectedLine =  $commentManager -> updateComment($commentId); 
        return $affectedLine;
    }

    /**
     * Retrieves and send comment data to delete comment page
     * 
     * @param int $commentId Id of comment
     * 
     * @return void
     */
    public function deleteCommentView($commentId)
    {
        $var = new \config\GlobalVar;

        $commentManager = new \model\CommentManager;
        $data = $commentManager -> getComment($commentId);
        if ($data == false) {
            throw new \Exception(PAGE_NOT_EXIST);
        }
        $comment = new \model\Comment($data);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/deleteCommentView.twig', array(
                'user' => $this->user,
                'comment' => $comment 
            )
        );
        $var->setSession('comment', $comment);
    }

    /**
     * Delete comment
     * 
     * @return void
     */
    public function deleteComment()
    {
        $var = new \config\GlobalVar;
        $commentManager = new \model\CommentManager;
        $addMsgEmail = null;

        if ($var->issetSession('comment')) {

            if ($var->issetPost('addMsgEmail')) {
                $addMsgEmail = $var->post('addMsgEmail');
            } 
            $affectedLine = $commentManager -> deleteComment(
                $var->session('comment')->commentId()
            );

            $this -> deleteCommentMail($affectedLine, $addMsgEmail);
        }   
    }

    /**
     * Send an email to visitor who write comment that will be delete
     * 
     * @param int    $affectedLine Number of affected line when delete comment
     * @param string $addMsgEmail  Message send to a visitor
     * 
     * @return void
     */
    public function deleteCommentMail($affectedLine, $addMsgEmail)
    {
        $var = new \config\GlobalVar;

        if ($affectedLine == 1) {
                
            $message = $var->session('comment')->nameVisitor() . ', '
             . NO_VALID_COMMENT_EMAIL
             . ' : <p>' . $var->session('comment')->content() . '</p>'
             . '<p>' . $addMsgEmail . '</p>'
             . $var->session('user')->userName() . ' : '
             . $var->session('user')->type() . '</p>';
             
            $data = array(
                'inputName' => $var->session('user')->userName(),
                'inputEmail' => $var->session('comment')->emailVisitor(),
                'inputMessage' => $message
            );
        
            $controller = new \controller\Controller;
            $controller -> sendMessage(
                $data, $var->session('comment')-> emailVisitor()
            );
            return;
        }
        throw new \Exception(COMMENT_NO_EXIST);   
    }

    /**
     * Retrieves and send comment data to list comment page
     * 
     * @param string $try Try of comment request results (date, author, post)
     * 
     * @return void
     */
    public function listComments($try=null)
    {
        $commentManager = new \model\CommentManager;
        $comments = $commentManager -> getAllComments(null, $try);
    
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backListCommentView.twig', array(
                'user' => $this->user,
                'comments' => $comments
            )
        );
    }

    /**
     * Valid delete comment
     * 
     * @return void
     */
    public function validDeleteComment()
    {
        $var = new \config\GlobalVar;

        if ($var->issetPost('cancelDeleteComment')) {
            if ($var->issetGet('del')) {  
                header('Location: index.php?admin=listcomments');
                exit();
            }
            header('Location: index.php?admin=validcomment');
            exit();
        }
        
        if ($var->issetPost('validDeleteComment')) {
            $this -> deleteComment($var->get('delete'));

            if ($var->issetGet('del')) {  
                header('Location: index.php?admin=listcomments');
                exit();
            } 
            header('Location: index.php?admin=validcomment');
            exit();
        }

        $this -> deleteCommentView($var->get('delete'));
        return;
    }

    /**
     * Action buttons on list comment page
     * 
     * @return void
     */
    public function listCommentsAction()
    {
        $var = new \config\GlobalVar;

        if ($var->issetPost('byPost')) {
            $this -> listComments('post_id');
            return;
        } 

        if ($var->issetPost('byDate')) {
            $this -> listComments('commentDate');
            return;
        } 
        
        if ($var->issetPost('byName')) {
            $this -> listComments('nameVisitor');
            return;
        } 

        $this -> listComments();
        return;
    }
}

