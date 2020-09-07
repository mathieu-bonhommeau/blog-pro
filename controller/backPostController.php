<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackPostController extends BackController
{
    public function backListPosts()
    {
        $postManager = new \model\PostManager;
        
        if ($_SESSION['user']->type() == 'administrator') {
            $posts = $postManager -> getPosts();
        } elseif ($_SESSION['user']->type() == 'author') {
            $posts = $postManager -> getUserPosts($_SESSION['user']->userId());
        }

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backListPostView.twig', array(
                'user' => $this->user,
                'posts' => $posts 
            )
        );
    }

    public function backListPostsAction()
    {
        if (isset($_GET['published'])) {
            $this -> publishedPost($_GET['published']);
            return; 
        }   
        if (isset($_GET['delete'])) { 
            if (isset($_POST['validDelete'])) {
                $this -> deletePost($_GET['delete']);
                return;

            } elseif (isset($_POST['cancelDelete'])) {    
                header('Location: index.php?admin=post');
                exit();  

            } else {
                $this -> deleteView($_GET['delete']);
                return;  
            }    
        }
        $this -> backListPosts();
           
    }

    public function addPostView(
        array $form=null, 
        $msg=null, 
        \model\Post $postPreview=null
    ) { 
        if ($form != null) {
            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            
            if ($newPost->postId() == null) {
                $result = $postManager -> addPost($newPost);
                $this -> resultPost($result[0], $result[1]);

            } else {
                
                $result = $postManager -> updatePost($newPost);
                
                $this -> resultPost($result, $newPost->postId());
            }
        }
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'backView/addPostView.twig', array(
                'user' => $this->user,
                'msg' => $msg,
                'postPreview' => $postPreview  
            )
        );
    }

    

    public function resultPost($affectedLines, $id) 
    {
        $postManager = new \model\PostManager;

        if ($affectedLines != 1) {
            $_SESSION['addPostMsg'] = POST_NO_OK;
            header('Location: index.php?admin=addpost');
            exit(); 
        }

        $data = $postManager -> getPost($id);
        $newPost = new \model\Post($data);
            
        if ($newPost->published() != 'TRUE') {
            $_SESSION['addPostMsg'] = MSG_SAVE;
            $this -> deleteSession('previewPost');
            header('Location: index.php?admin=addpost');
            exit();
        }

        if ((isset($_SESSION['previewPost']) 
            && isset($_SESSION['oldImage'])) && (basename(
                $_SESSION['previewPost']->picture()
            )  != $_SESSION['oldImage'])
        ) {
            unlink(POST_IMG_DIRECTORY . $_SESSION['oldImage']);  
        }
        $this -> deleteSession('previewPost');
        header('Location: index.php?p=post&id=' . $newPost->postId());
        exit();     
    }

    public function previewPost(array $form)
    {
        $newPost = new \model\Post($form);
        $newPost -> setLastDateModif(time());
        $newPost -> setAuthorName($_SESSION['user']->authorName());

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView\postPreview.twig', array(
                'user' => $this->user,
                'newPost' => $newPost    
            )
        );
        $_SESSION['previewPost'] = $newPost;
    }

    public function inputPostTest() 
    {
        if ((empty($_POST['titlePost']) 
            && empty($_POST['chapoPost']) 
            && empty(filter_input(INPUT_POST, 'contentPost', FILTER_SANITIZE_SPECIAL_CHARS))) 
            && (isset($_SESSION['previewPost']))
        ) {
            $_POST['titlePost'] = $_SESSION['previewPost']->title();
            $_POST['chapoPost'] = $_SESSION['previewPost']->chapo();
            $_POST['contentPost'] = $_SESSION['previewPost']->content();  
        }
        return;
    }

    public function dataInputPost($id=null)
    {
        $backImageController = new \controller\BackPImgController;
        $this -> inputPostTest();

        if (!empty($_POST['titlePost'])
            && !empty($_POST['chapoPost'])
            && !empty($_POST['contentPost'])
        ) {
            if (empty($_FILES['imgPost']['name'])) {
                $path = $backImageController->managePostImage();
    
            } else {
                $path =  $backImageController -> uploadFile($_FILES['imgPost']);  
            }
            $form = array(
                'id' => $id,
                'title' => $_POST['titlePost'],'chapo' => $_POST['chapoPost'],
                'content' => $_POST['contentPost'],'picture' => $path,
                'published' => 'FALSE'   
            );
            return $form;

        }
        $_SESSION['addPostMsg'] = EMPTY_FIELDS;
        header('Location: index.php?admin=addpost');
    }

    public function publishedPost($id) 
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($id);
        if ($data) {
            $post = new \model\Post($data);
            $post -> setPublished('TRUE');
            
            $affectedLine = $postManager -> updatePost($post);
            
            if ($affectedLine == 1 && $_GET['c'] == 'valid') {
                
                header('Location: index.php?p=post&id=' . $id);

            } elseif ($affectedLine == 1 && $_GET['c'] != 'valid') {
                
                header('Location: index.php?admin=post');
            }
            throw new \Exception(POST_NO_OK); 
            return;   
        } 
        throw new \Exception(POST_NO_EXIST);
        
    }

    public function updatePost($id)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($id);
        
        if ($data) {
            $post = new \model\Post($data);
            
            $_SESSION['oldImage'] = basename($post->picture());

            if ($post->picture() != null 
                && file_exists(POST_IMG_DIRECTORY . $post->picture())
            ) {
                $this -> verifTmpFolder();
                copy(
                    POST_IMG_DIRECTORY . $post->picture(), 'tmp/' 
                    . 'tmp' . $post->picture()
                );
                $post->setPicture('tmp/' . 'tmp' . $post->picture());
            }
            return $post;
        } 
        throw new \Exception(POST_NO_EXIST);  
    }

    public function deleteView($id)
    {
        $postManager = new \model\PostManager;
        $dataPost = $postManager -> getPost($id);

        if ($dataPost == false) {
            throw new \Exception(PAGE_NOT_EXIST);

        } else {
            $post = new \model\Post($dataPost);

            $commentManager = new \model\CommentManager;
            $dataComment = $commentManager -> getComments($id, 'TRUE');
            $nbrComments = $commentManager -> nbrComments($id, 'TRUE');

            $this->twigInit();
            $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
            $this->twig->addExtension(new Twig_Extensions_Extension_Text());

            echo $this->twig->render(
                'backView/deletePostView.twig', array(
                    'post' => $post,
                    'comments' => $dataComment,
                    'nbrComments' => $nbrComments['COUNT(*)'],
                    'user' => $this->user
                )
            );
        }      
    }

    public function deletePost($postId)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($postId);
        $post = new \model\Post($data);

        $commentManager = new \model\CommentManager;
        $commentManager->deletePostComments($postId);
        
        $affectedLines = $postManager->deletePost($postId);

        if ($affectedLines == 1) {
            unlink(POST_IMG_DIRECTORY . basename($post->picture()));
            header('Location: index.php?admin=post');

        } else {
            throw new \Exception(POST_NO_SUP);
        }
    }

   

    public function deleteSession($name) 
    {
        if (isset($_SESSION[$name]) && (file_exists($_SESSION[$name] -> picture()))
        ) {
            $postManager = new \model\PostManager;
            $result = $postManager -> getPostImg(basename($_SESSION[$name] -> picture()));
            if ($result == 0) {
                unlink($_SESSION[$name] -> picture());
            }
            unset($_SESSION[$name]);
            return; 
        }
        if (isset($_SESSION[$name]) && (!file_exists($_SESSION[$name] -> picture()))
        ) {
            unset($_SESSION[$name]);
            return;
        }
        return;      
        
    }

    public function verifTmpFolder()
    {
        if (!file_exists('tmp/')) {
            mkdir('tmp/');
        }
    }
}