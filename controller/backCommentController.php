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

    public function updateComment($id)
    {
        $commentManager = new \model\CommentManager;
        $affectedLine =  $commentManager -> updateComment($id); 
        return $affectedLine;
    }

    public function deleteCommentView($id)
    {
        $commentManager = new \model\CommentManager;
        $data = $commentManager -> getComment($id);
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

    public function deleteComment($id)
    {
        $commentManager = new \model\CommentManager;

        if (isset($_SESSION['comment'])) {
            $comment = $_SESSION['comment'];

            if ((isset($_POST['addMsgEmail']))) {
                $addMsgEmail = $_POST['addMsgEmail'];
            } else {
                $addMsgEmail = null;
            }

            $affectedLine = $commentManager -> deleteComment($comment->id());
            
            if ($affectedLine == 1) {
                
                $message = $comment->nameVisitor() . ', '
                 . NO_VALID_COMMENT_EMAIL
                 . ' : <p>' . $comment->content() . '</p>'
                 . '<p>' . $addMsgEmail . '</p>'
                 . $_SESSION['user']->userName() . ' : '
                 . $_SESSION['user']->type() . '</p>';
                 
                $data = array(
                    'inputName' => $_SESSION['user']->userName(),
                    'inputEmail' => $comment->emailVisitor(),
                    'inputMessage' => $message

                );
            
                $controller = new \controller\Controller;
                $controller -> sendMessage($data, $comment-> emailVisitor());

            } else {
                throw new \Exception(COMMENT_NO_EXIST);
            }
        }   
    }

    public function listComments($try=null)
    {
        $commentManager = new \model\CommentManager;
        $comments = $commentManager -> getAllComments($validComment=null, $try);
    
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

