<?php

/**
 * This file contains RouterBack class
 */
namespace config;

/**
 * Class for routing on back pages
 */
class RouterBack
{
    /**
     * Routing on back pages
     * 
     * @param string $get Index $_GET
     * 
     * @return mixed
     */
    public function runBackPage($get)
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession('user')) {
            $backController = new \controller\backController;
            $backPostController = new \controller\backPostController;
            $backCommentController = new \controller\BackCommentController;
            $backUserController = new \controller\backUserController;
            $backAddPostController = new \controller\BackAddPostController;

            if ($get == 'backhome') {
                $backPostController -> deleteSession('previewPost');
                $backController -> backHomePage();
                return;

            } elseif ($get == 'post'
                && ($var->session('user')->type() == 'administrator'
                || $var->session('user')->type() == 'author')
            ) {
                $backPostController -> deleteSession('previewPost');
                $backPostController -> backListPostsAction();
                return;

            } elseif ($get == 'addpost'
                && ($var->session('user')->type() == 'administrator'
                || $var->session('user')->type() == 'author')
            ) {
                $backAddPostController -> addPostAction();
                return;

            } elseif ($get == 'validcomment') { 
                $backCommentController -> validComment();
                return;

            } elseif ($get == 'comment') {
                $backCommentController -> validDeleteComment();
                return;
                
            } elseif ($get == 'listcomments') {

                $backCommentController -> listCommentsAction();
                return;
 
            } elseif ($get == 'adduser' 
                && $var->session('user')->type() == 'administrator'
            ) {
                $frontController = new \controller\FrontController;
                if ($var->issetPost('addUser')) {
                
                    if ($var->issetPost('userName')
                        && $var->noEmptyPost('userPassword')
                        && $var->noEmptyPost('userPasswordConfirm')
                        && $var->issetPost('userType')
                    ) {
                        $backUserController -> testAddUser();
                        return;
                    }
                    $var->setSession('addUserMsg', EMPTY_FIELDS);
                    header('Location: index.php?admin=adduser');
                    exit();

                } elseif ($var->issetGet('id')) {
                    $form = $backUserController -> getUpdateUser($var->get('id'));
                    $backUserController -> addUserView($form);
                    return;
                    
                } else {
                    $backUserController -> addUserView();
                    return;
                }

            } elseif ($get == 'listusers'
                && $var->session('user')->type() == 'administrator'
            ) {
                $backUserController -> listUsers();
                return;

            } elseif ($get == 'deleteuser'
                && $var->session('user')->type() == 'administrator'
            ) {  
                if ($var->issetGet('id')) {
                    $backUserController -> deleteUser($var->get('id'));
                    return;
                } 
                throw new \Exception(PAGE_NOT_EXIST);

            } elseif ($get == 'profil') {
                if ($var->issetGet('id')) {
                    if ($var->issetPost('updateProfil')
                        && $var->issetPost('userName')
                        && $var->issetPost('userPassword')
                        && $var->issetPost('userPasswordConfirm')
                    ) {
                        $backUserController -> dataInputProfil();
                        return;
                        
                    } elseif ($var->issetGet('c') 
                    ) {
                        $backUserController -> profilView(
                            $var->get('id'), $var->get('c')
                        );
                        return;
                    
                    } elseif ($var->issetPost('profilPictureChange')) {
                        $var->setSession('resetImage', 'reset');
                        header(
                            'Location: index.php?admin=profil&id=' 
                            . $var->get('id') . '&c=update'
                        );
                        exit();
                    }   
                    $backUserController -> profilView($var->get('id'));
                    return;
                }
                return;
            }
            throw new \Exception(PAGE_NOT_EXIST);
        }
        throw new \Exception(NO_ACCESS);
        
    }    
}