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
            $backImageController = new \controller\BackPImgController;

            if ($get == 'backhome') {
                $backPostController -> deleteSession('previewPost');
                $backController -> backHomePage();

            } elseif ($get == 'post'
                && ($_SESSION['user']->type() == 'administrator'
                || $_SESSION['user']->type() == 'author')
            ) {
                $backPostController -> deleteSession('previewPost');

                if (isset($_GET['published'])) {
                    $backPostController -> publishedPost($_GET['published']);    

                } elseif (isset($_GET['delete'])) {
                    if (isset($_POST['validDelete'])) {
                        $backPostController -> deletePost($_GET['delete']);

                    } elseif (isset($_POST['cancelDelete'])) {    
                        header('Location: index.php?admin=post');
                        
                    } else {
                        $backPostController -> deleteView($_GET['delete']);   
                    }
                } else { 
                    $backPostController -> backListPosts();   
                }

            } elseif ($get == 'addpost'
                && ($_SESSION['user']->type() == 'administrator'
                || $_SESSION['user']->type() == 'author')
            ) {
                
                if (isset($_POST['addPost'])) {
                    
                    if (isset($_GET['id'])) { 
                        $form = $backPostController -> dataInputPost($_GET['id']);
                        
                    } else {
                        
                        $form = $backPostController -> dataInputPost();   
                    }
                    
                    $form['published'] = 'TRUE';
                   
                    $backPostController -> addPostView($form);

                } elseif (isset($_POST['preview'])) {
                    if (isset($_GET['id'])) {
                        $form = $backPostController -> dataInputPost($_GET['id']);
                    } else {
                        $form = $backPostController -> dataInputPost();
                    }
                    $backPostController -> previewPost($form);

                } elseif (isset($_POST['notPublished'])) {  
                    if (isset($_GET['id'])) {
                        $form = $backPostController -> dataInputPost($_GET['id']);
                    } else {
                        $form = $backPostController -> dataInputPost();
                    }
                    $form['published'] = 'FALSE';
                    $backPostController -> addPostView($form);

                } elseif (isset($_POST['imgChange'])) {
                    $backImageController  -> imgChange();

                } elseif (isset($_GET['id'])) {
                    if (isset($_SESSION['previewPost'])) {
                        $updatePost = $_SESSION['previewPost'];
                        
                    } else {
                        $updatePost = $backPostController  -> updatePost($_GET['id']);
                        
                        $_SESSION['previewPost'] = $updatePost;
                    }
                    
                    $backPostController  -> addPostView($form=null, null, $updatePost);
                    
                } elseif (isset($_SESSION['previewPost'])) {
                    $previewPost = $_SESSION['previewPost'];
                    $backPostController  -> addPostView($form=null, $msg=null, $previewPost);
                    
                
                } else {
                    if (isset($_SESSION['addPostMsg'])) {
                        $backPostController  -> addPostView(null, $_SESSION['addPostMsg']);
                        unset($_SESSION['addPostMsg']);

                    } else {
                        $backPostController -> addPostView();
                        
                    } 
                }

            } elseif ($get == 'validcomment') { 
                $backCommentController -> validComment();

            } elseif ($get == 'comment') {
                
                if (isset($_POST['cancelDeleteComment'])) {
                    if (isset($_GET['del'])) {  
                        header('Location: index.php?admin=listcomments');
                    } else {
                        header('Location: index.php?admin=validcomment');
                    }
                    
                } elseif (isset($_POST['validDeleteComment'])) {
                    $backCommentController -> deleteComment($_GET['delete']);
                    if (isset($_GET['del'])) {  
                        header('Location: index.php?admin=listcomments');
                    } else {
                        header('Location: index.php?admin=validcomment');
                    }

                } else {
                    $backCommentController -> deleteCommentView($_GET['delete']);
                }

            } elseif ($get == 'listcomments') {

                if (isset($_POST['byPost'])) {
                    $backCommentController -> listComments('post_id');
                } elseif (isset($_POST['byDate'])) {
                    $backCommentController -> listComments('commentDate');
                } elseif (isset($_POST['byName'])) {
                    $backCommentController -> listComments('nameVisitor');
                } else {
                    $backCommentController -> listComments();
                }
            
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
                        
                        if ($_POST['userPassword'] == $_POST['userPasswordConfirm'] ) {
                            if (isset($_GET['id']) && isset($_SESSION['updateUser'])) {
                                $form = array(
                                    'id' => $_GET['id'],
                                    'userName' => $_POST['userName'],
                                    'password' => $_POST['userPassword'],
                                    'userEmail' => $_SESSION['updateUser']->userEmail(),
                                    'profilPicture' => $_SESSION['updateUser']->profilPicture(),
                                    'authorName' => $_SESSION['updateUser']->authorName(),
                                    'type' => $_POST['userType'] 
                                );
                                
                                unset($_SESSION['updateUser']);
                                $affectedLine = $backUserController -> updateUser($form);
                                
                                if ($_SESSION['user']->userId() == $_GET['id']) {
                                    
                                    $frontController -> verifyUser(
                                        $_POST['userName'], 
                                        $_POST['userPassword']
                                    );
                                    header('Location: index.php?admin=backhome');
                                }

                            } else {
                                $form = array(
                                    'userName' => $_POST['userName'],
                                    'password' => password_hash(
                                        $_POST['userPassword'], 
                                        PASSWORD_DEFAULT
                                    ),
                                    'type' => $_POST['userType'] 
                                );
                                $affectedLine = $backUserController -> addUser($form);
                            }
                            
                            if ($affectedLine == 1 ) {
                                $_SESSION['addUserMsg'] = ADD_USER_OK;
                                header('Location: index.php?admin=adduser');

                            } else {
                                $_SESSION['addUserMsg'] = ADD_USER_NO_OK;
                                header('Location: index.php?admin=adduser');
                            }
                            
                        } else {
                            $_SESSION['addUserMsg'] = USER_NO_OK;
                            header('Location: index.php?admin=adduser');
                        } 

                    } else {
                        $_SESSION['addUserMsg'] = EMPTY_FIELDS;
                        header('Location: index.php?admin=adduser');
                        
                    }

                } elseif (isset($_GET['id'])) {
                    $form = $backUserController -> getUpdateUser($_GET['id']);
                    $backUserController -> addUserView($form);
                    
                } else {
                
                    $backUserController -> addUserView();
                }

            } elseif ($get == 'listusers'
                && $_SESSION['user']->type() == 'administrator'
            ) {
                $backUserController -> listUsers();

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