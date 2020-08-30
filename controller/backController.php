<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackController extends Controller
{
    public function backHomePage()
    {
        $postManager = new \model\PostManager;
        $nbrPosts = $postManager -> countPosts();
        $lastDatePost = $postManager -> lastDatePost();

        $commentManager = new \model\CommentManager;
        $nbrCommentNoValid = $commentManager -> nbrAllComments('FALSE');
        $lastDateComment = $commentManager -> lastDateComment();

        $userManager = new \model\userManager;
        $nbrUser = $userManager->countUser();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backHomeView.twig', array(
                'user' => $this->user,
                'nbrPosts' => $nbrPosts,
                'lastDatePost' => $lastDatePost,
                'nbrCommentNoValid' => $nbrCommentNoValid,
                'lastDateComment' => $lastDateComment,
                'nbrUser' => $nbrUser
            )
        );
    }
}