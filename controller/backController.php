<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackController extends Controller
{
    public function backHomePage()
    {
        $postManager = new \model\PostManager;
        
        $nbrPosts = null;
        $lastDatePost = null;

        if ($_SESSION['user']->type() == 'administrator') {
            $nbrPosts = $postManager -> countPosts();
            $lastDatePost = $postManager -> lastDatePost();
        } elseif ($_SESSION['user']->type() == 'author') {
            $nbrPosts = $postManager -> countUserPosts($_SESSION['user']->id());
            $lastDatePost = $postManager -> lastDateUserPost(
                $_SESSION['user']->id()
            );
        } 
        
        $commentManager = new \model\CommentManager;
        $nbrCommentNoValid = $commentManager -> nbrAllComments('FALSE');
        $lastDateComment = $commentManager -> lastDateComment();

        $userManager = new \model\userManager;
        $nbrUser = $userManager->countUser();
        $lastAddedUser = $userManager->lastAddedUser();

        $this->twigInit();

        echo $this->twig->render(
            'backView/backHomeView.twig', array(
                'user' => $this->user,'nbrPosts' => $nbrPosts,
                'lastDatePost' => $lastDatePost,
                'nbrCommentNoValid' => $nbrCommentNoValid,
                'lastDateComment' => $lastDateComment,
                'nbrUser' => $nbrUser,'lastAddedUser' => $lastAddedUser
            )
        );
    }
}