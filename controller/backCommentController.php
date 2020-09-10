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

