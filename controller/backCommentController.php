<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackCommentController extends BackController
{
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

    public function updateComment($commentId)
    {
        $commentManager = new \model\CommentManager;
        $affectedLine =  $commentManager -> updateComment($commentId); 
        return $affectedLine;
    }

    public function deleteCommentView($commentId)
    {
        $commentManager = new \model\CommentManager;
        $data = $commentManager -> getComment($commentId);
        $comment = new \model\Comment($data);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/deleteCommentView.twig', array(
                'user' => $this->user,
                'comment' => $comment 
            )
        );
        $_SESSION['comment'] = $comment;
    }

    public function deleteComment()
    {
        $commentManager = new \model\CommentManager;
        $addMsgEmail = null;

        if (isset($_SESSION['comment'])) {

            if ((isset($_POST['addMsgEmail']))) {
                $addMsgEmail = $_POST['addMsgEmail'];
            } 
            $affectedLine = $commentManager -> deleteComment(
                $_SESSION['comment']->commentId()
            );
            $this -> deleteCommentMail($affectedLine, $addMsgEmail);
        }   
    }

    public function deleteCommentMail($affectedLine, $addMsgEmail)
    {
        if ($affectedLine == 1) {
                
            $message = $_SESSION['comment']->nameVisitor() . ', '
             . NO_VALID_COMMENT_EMAIL
             . ' : <p>' . $_SESSION['comment']->content() . '</p>'
             . '<p>' . $addMsgEmail . '</p>'
             . $_SESSION['user']->userName() . ' : '
             . $_SESSION['user']->type() . '</p>';
             
            $data = array(
                'inputName' => $_SESSION['user']->userName(),
                'inputEmail' => $_SESSION['comment']->emailVisitor(),
                'inputMessage' => $message
            );
        
            $controller = new \controller\Controller;
            $controller -> sendMessage(
                $data, $_SESSION['comment']-> emailVisitor()
            );
            return;

        }
        throw new \Exception(COMMENT_NO_EXIST);
        
    }

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
}

