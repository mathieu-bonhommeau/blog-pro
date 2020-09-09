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
        $var = new \config\GlobalVar;

        $infos['nbrPosts'] = null;
        $infos['lastDatePost'] = null;

        if ($var->session('user')->type() == 'administrator') {
            $infos['nbrPosts'] = $postManager -> countPosts();
            $infos['lastDatePost'] = $postManager -> lastDatePost();

        } elseif ($var->session('user')->type() == 'author') {
            $infos['nbrPosts'] = $postManager -> countUserPosts(
                $var->session('user')->userId()
            );
            $infos['lastDatePost'] = $postManager -> lastDateUserPost(
                $var->session('user')->userId()
            );
        }
        return $infos;
    }
}