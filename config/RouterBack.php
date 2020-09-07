<?php

namespace config;

class RouterBack
{ 
    public function runBackPage($get)
    {
        if (isset($_SESSION['user'])) {
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
                && ($_SESSION['user']->type() == 'administrator'
                || $_SESSION['user']->type() == 'author')
            ) {
                $backPostController -> deleteSession('previewPost');
                $backPostController -> backListPostsAction();
                return;

            } elseif ($get == 'addpost'
                && ($_SESSION['user']->type() == 'administrator'
                || $_SESSION['user']->type() == 'author')
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
                && $_SESSION['user']->type() == 'administrator'
            ) {
                $frontController = new \controller\FrontController;
                if (isset($_POST['addUser'])) {
                
                    if (isset($_POST['userName'])
                        && !empty($_POST['userPassword'])
                        && !empty($_POST['userPasswordConfirm'])
                        && isset($_POST['userType'])
                    ) {
                        $backUserController -> testAddUser();
                        return;
                    }

                    $_SESSION['addUserMsg'] = EMPTY_FIELDS;
                    header('Location: index.php?admin=adduser');
                    exit();
                    

                } elseif (isset($_GET['id'])) {
                    $form = $backUserController -> getUpdateUser($_GET['id']);
                    $backUserController -> addUserView($form);
                    return;
                    
                } else {
                    $backUserController -> addUserView();
                    return;
                }

            } elseif ($get == 'listusers'
                && $_SESSION['user']->type() == 'administrator'
            ) {
                $backUserController -> listUsers();
                return;

            } elseif ($get == 'deleteuser'
                && $_SESSION['user']->type() == 'administrator'
            ) {  
                if (isset($_GET['id'])) {

                    if (isset($_POST['validDeleteUser'])) {
                        $affectedLine = $backUserController -> deleteUser($_GET['id']);
                        if ($affectedLine == 1) {
                            header('Location: index.php?admin=listusers');

                        } else {
                            throw new \Exception(USER_NO_DELETE);
                        }
                    
                    } else {
                        
                        $backUserController -> deleteUserView($_GET['id']);
                    }

                } else {
                    throw new \Exception(PAGE_NOT_EXIST);
                }

            } elseif ($get == 'profil') {
                if (isset($_GET['id'])) {
                    if (isset($_POST['updateProfil'])
                        && isset($_POST['userName'])
                        && isset($_POST['userPassword'])
                        && isset($_POST['userPasswordConfirm'])
                    ) {
                        $userEmail = null;
                        $authorName = null;
                        $profilPicture = null;

                        if ($_POST['userPassword'] == $_POST['userPasswordConfirm']) {
                            if (isset($_POST['userEmail'])) {
                                $userEmail = $_POST['userEmail'];
                            } 

                            if (isset($_POST['authorName'])) {
                                $authorName = $_POST['authorName'];
                            } 

                            if (isset($_FILES['profilPictureUpload'])
                                && $_FILES['profilPictureUpload']['name'] != null
                            ) {
                                $profilPicture = $backUserController ->
                                uploadProfilPicture(
                                    $_FILES['profilPictureUpload']
                                ); 
                            } elseif (isset($_POST['profilPictureUpload'])) {
                                $profilPicture = $_POST['profilPictureUpload'];
                            } 
                            
                            $form = array(
                                'id' => $_GET['id'],
                                'userName' => $_POST['userName'],
                                'password' =>  password_hash(
                                    $_POST['userPassword'],
                                    PASSWORD_DEFAULT
                                ),
                                'userEmail' => $userEmail,
                                'authorName' => $authorName,
                                'profilPicture' => basename($profilPicture),
                                'type' => $_SESSION['user']->type()
                            );

                            $backUserController -> updateUser($form);
                            
                            $frontController = new \controller\FrontController;
                            
                            $frontController -> verifyUser(
                                $_POST['userName'], 
                                $_POST['userPassword']
                            );
                            header('Location: index.php?admin=profil&id=' . $_GET['id']);

                        } else {
                            $_SESSION['updateUserMsg'] = USER_NO_OK;
                            header('Location: index.php?admin=profil&id=' . $_GET['id']);
                        }

                    } elseif (isset($_GET['c']) 
                    ) {
                        $backUserController -> profilView($_GET['id'], $_GET['c']);
                    
                    } elseif (isset($_POST['profilPictureChange'])) {
                        $_SESSION['resetImage'] = 'reset';
                        header('Location: index.php?admin=profil&id=' . $_GET['id'] . '&c=update');

                    } else {
                        
                        $backUserController -> profilView($_GET['id']);
                    }
                } else {
                    throw new \Exception(PAGE_NOT_EXIST);
                }

            } else {
                throw new \Exception(PAGE_NOT_EXIST);
            } 

        } else {
            throw new \Exception(NO_ACCESS);
        }
    }    
}