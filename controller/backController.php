<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackController extends Controller
{
    public function backHomePage()
    {
        $infos = $this -> backHomePostBadge();
        
        $commentManager = new \model\CommentManager;
        $nbrCommentNoValid = $commentManager -> nbrAllComments('FALSE');
        $lastDateComment = $commentManager -> lastDateComment();

        $userManager = new \model\userManager;
        $nbrUser = $userManager->countUser();
        $lastAddedUser = $userManager->lastAddedUser();

        $this->twigInit();

        echo $this->twig->render(
            'backView/backHomeView.twig', array(
                'user' => $this->user,'nbrPosts' => $infos['nbrPosts'],
                'lastDatePost' => $infos['lastDatePost'],
                'nbrCommentNoValid' => $nbrCommentNoValid,
                'lastDateComment' => $lastDateComment,
                'nbrUser' => $nbrUser,'lastAddedUser' => $lastAddedUser
            )
        );
    }

    public function backHomePostBadge()
    {
        $postManager = new \model\PostManager;

        $infos['nbrPosts'] = null;
        $infos['lastDatePost'] = null;

        if ($_SESSION['user']->type() == 'administrator') {
            $infos['nbrPosts'] = $postManager -> countPosts();
            $infos['lastDatePost'] = $postManager -> lastDatePost();

        } elseif ($_SESSION['user']->type() == 'author') {
            $infos['nbrPosts'] = $postManager -> countUserPosts(
                $_SESSION['user']->id()
            );
            $infos['lastDatePost'] = $postManager -> lastDateUserPost(
                $_SESSION['user']->id()
            );
        }
        return $infos;
    }
}