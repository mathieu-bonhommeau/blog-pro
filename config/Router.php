<?php

namespace config;

class Router 
{ 
    public function runFrontPage($get)
    {
        if ($get == 'home') {
            
            $frontController = new \controller\FrontController;

            if (isset($_POST['submitMessage'])) {
                if (!empty($_POST['inputName']) 
                    && !empty($_POST['inputFirstName']) 
                    && !empty($_POST['inputEmail']) 
                    && !empty($_POST['inputMessage'])
                ) {
                    $form = array('inputName' => $_POST['inputName'], 
                                'inputFirstName' => $_POST['inputFirstName'], 
                                'inputEmail' => $_POST['inputEmail'], 
                                'inputMessage' => $_POST['inputMessage']
                    );
                    
                    $msg = $this -> runSendMessage($form);   
                
                } else {
                    $msg = EMPTY_FIELDS;
                }

                $_SESSION['msg'] = $msg;

                header('Location: index.php?p=home#signup'); 
                exit();

            } else {

                if (isset($_SESSION['msg'])) {
                    $frontController -> homePage($_SESSION['msg']);
                    unset($_SESSION['msg']);

                } else {
                    $frontController -> homePage();
                }
                
            }

            
        } elseif ($get == 'listposts') {

            $frontController = new \controller\FrontController;
            $frontController -> listPostsView(); 

            
        } elseif ($get == 'post') {

            if (isset($_GET['id'])) {

                $frontController = new \controller\FrontController;

                if (isset($_POST['submitComment'])) {
                    
                    if (!empty($_POST['nameVisitor']) 
                        && !empty($_POST['emailVisitor']) 
                        && !empty($_POST['content'])
                    ) {
                        // if $user exist
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                        } else {
                            $user_id = null;
                        }
                        
                        $form = array(
                            'nameVisitor' => $_POST['nameVisitor'],
                            'emailVisitor' => $_POST['emailVisitor'],
                            'content' => $_POST['content'],
                            'validComment' => 'FALSE',
                            'user_id' => $user_id,
                            'post_id' =>$_GET['id']
                        );
                        
                        $msg = $frontController -> addNewComment($form); 
                        
                    } else {
                        $msg = EMPTY_FIELDS;
                    }

                    $_SESSION['commentMsg'] = $msg;

                    header('Location: index.php?p=post&id=' . $_GET['id']);
                    exit();

                } else {

                    if (isset($_SESSION['commentMsg'])) {
                        $frontController -> postView(
                            $_GET['id'], $_SESSION['commentMsg']
                        );
                        unset($_SESSION['commentMsg']);
                    } else {
                        $frontController -> postView($_GET['id']);
                    }   
                }

            } else {
                throw new \Exception(PAGE_NOT_EXIST);
            }

        } elseif ($get == 'connect') {

            $frontController = new \controller\FrontController;

            if (isset($_POST['submitConnect'])) {

                if (!empty($_POST['inputPseudoConnect']) 
                    && !empty($_POST['inputPasswordConnect'])
                ) {

                    $msgConnect = $frontController -> verifyUser(
                        $_POST['inputPseudoConnect'], 
                        $_POST['inputPasswordConnect']    
                    );
                
                    $_SESSION['msgConnect'] = $msgConnect;
                    header('Location: index.php?p=connect');
                    exit();

                } else {

                    $msgConnect = EMPTY_FIELDS;
                    $frontController -> connectView($msgConnect);

                }
            } else {
            
                if (isset($_SESSION['msgConnect'])) {

                    $frontController -> connectView($_SESSION['msgConnect']);
                    unset($_SESSION['msgConnect']);

                } else {
                    $frontController -> connectView();
                }
            }    
        } elseif ($get == 'disconnect') {

                unset($_SESSION['user']);
                header('Location: index.php');
        }
    }

    public function runSendMessage(array $form)
    {
        $frontController = new \controller\FrontController;
        $frontController -> sendMessage($form);
        $msg = $frontController -> msg();
        return $msg;
    }

    public function runBackPage($get)
    {
        if (isset($_SESSION['user'])) {
            $backController = new \controller\backController;
            $backPostController = new \controller\backPostController;
            $backCommentController = new \controller\BackCommentController;

            if ($get == 'backhome') {
                $backPostController -> deleteSession('previewPost');
                $backController -> backHomePage();

            } elseif ($get == 'post') {
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

            } elseif ($get == 'addpost') {

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
                    $backPostController  -> imgChange();

                } elseif (isset($_GET['id'])) {
                    if (isset($_SESSION['previewPost'])) {
                        $updatePost = $_SESSION['previewPost'];
                    } else {
                        $updatePost = $backPostController  -> updatePost($_GET['id']);
                        $_SESSION['previewPost'] = $updatePost;
                    }
                    
                    $backPostController  -> addPostView($form=null, $msg=null, $updatePost);
                    
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

            } elseif ($get = 'validComment') {
                $backCommentController -> validComment();

            } else {
                throw new \Exception(PAGE_NOT_EXIST);
            }

        } else {
            throw new \Exception(NO_ACCESS);
        }
    }    
}