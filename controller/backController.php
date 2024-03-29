<?php

/**
 * This file contains BackController class
 */
namespace controller;

/**
 * Class for display back home page
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackController extends Controller
{
    /**
     * Display back home page
     * 
     * @return void
     */
    public function backHomePage()
    {
        $view = new \view\View;
        $infos = $this -> backHomePostBadge();
        
        $commentManager = new \model\CommentManager;
        $nbrCommentNoValid = $commentManager -> nbrAllComments('FALSE');
        $lastDateComment = $commentManager -> lastDateComment();

        $userManager = new \model\UserManager;
        $nbrUser = $userManager->countUser();
        $lastAddedUser = $userManager->lastAddedUser();

        $data = array(
            'user' => $this->user,'nbrPosts' => $infos['nbrPosts'],
            'lastDatePost' => $infos['lastDatePost'],
            'nbrCommentNoValid' => $nbrCommentNoValid,
            'lastDateComment' => $lastDateComment,
            'nbrUser' => $nbrUser,'lastAddedUser' => $lastAddedUser
        );
        $page = 'backView/backHomeView.twig';
        $view -> displayPage($data, $page);
    }

    /**
     * Retrieves data for back home page badges
     * 
     * @return array $infos Infos of badges
     */
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