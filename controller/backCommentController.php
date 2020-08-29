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
        return $commentManager -> updateComment($id);  
    }
}

