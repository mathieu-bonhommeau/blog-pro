<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackPostController extends BackController
{
    public function backListPosts()
    {
        $var = new \config\GlobalVar;
        $postManager = new \model\PostManager;
        
        if ($var->session('user')->type() == 'administrator') {
            $posts = $postManager -> getPosts();
        } elseif ($var->session('user')->type() == 'author') {
            $posts = $postManager -> getUserPosts($var->session('user')->userId());
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
        $var = new \config\GlobalVar;

        if ($var->issetGet('published')) {
            $this -> publishedPost($var->get('published'));
            return; 
        }   
        if ($var->issetGet('delete')) { 
            if ($var->issetPost('validDelete')) {
                $this -> deletePost($var->get('delete'));
                return;

            } elseif ($var->issetPost('cancelDelete')) {    
                header('Location: index.php?admin=post');
                exit();  

            } else {
                $this -> deleteView($var->get('delete'));
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
        $var = new \config\GlobalVar;

        if ($affectedLines != 1) {
            $var->setSession('addPostMsg', POST_NO_OK);
            header('Location: index.php?admin=addpost');
            exit(); 
        }

        $data = $postManager -> getPost($id);
        $newPost = new \model\Post($data);
            
        if ($newPost->published() != 'TRUE') {
            $var->setSession('addPostMsg', MSG_SAVE);
            $this -> deleteSession('previewPost');
            header('Location: index.php?admin=addpost');
            exit();
        }

        if (($var->issetSession('previewPost') 
            && $var->issetSession('oldImage')) && (basename(
                $var->session('previewPost')->picture()
            )  != $var->session('oldImage'))
        ) {
            unlink(POST_IMG_DIRECTORY . $var->session('oldImage'));  
        }
        $this -> deleteSession('previewPost');
        header('Location: index.php?p=post&id=' . $newPost->postId());
        exit();     
    }

    public function previewPost(array $form)
    {
        $var = new \config\GlobalVar;
        
        $newPost = new \model\Post($form);
        $newPost -> setLastDateModif(time());
        $newPost -> setAuthorName($var->session('user')->authorName());

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
        $var = new \config\GlobalVar;

        if (($var->emptyPost('titlePost') 
            && $var->emptyPost('chapoPost') 
            && $var->emptyPost('contentPost')) 
            && ($var->issetSession('previewPost'))
        ) {
            $var->setPost('titlePost', $var->session('previewPost')->title());
            $var->setPost('chapoPost', $var->session('previewPost')->chapo());
            $var->setPost('contentPost', $var->session('previewPost')->content());  
        }
        return;
    }

    public function dataInputPost($id=null)
    {
        $var = new \config\GlobalVar;
        $backImageController = new \controller\BackPImgController;

        $this -> inputPostTest();

        if ($var->noEmptyPost('titlePost')
            && $var->noEmptyPost('chapoPost')
            && $var->noEmptyPost('contentPost')
        ) {
            if (empty($_FILES['imgPost']['name'])) {
                $path = $backImageController->managePostImage();
    
            } else {
                $path =  $backImageController -> uploadFile($_FILES['imgPost']);  
            }
            $form = array(
                'id' => $id,
                'title' => $var->post('titlePost'),
                'chapo' => $var->post('chapoPost'),
                'content' => $var->post('contentPost'),'picture' => $path,
                'published' => 'FALSE'   
            );
            return $form;

        }
        $var->setSession('addPostMsg', EMPTY_FIELDS);
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
        $var = new \config\GlobalVar;

        if ($var->issetSession($name) 
            && (file_exists(
                $var->session($name) -> picture()
            ))
        ) {
            $postManager = new \model\PostManager;
            $result = $postManager -> getPostImg(
                basename($var->session($name) -> picture())
            );
            if ($result == 0) {
                unlink($var->session($name) -> picture());
            }
            $var->unsetSession($name);
            return; 
        }
        if ($var->issetSession($name) 
            && (!file_exists($var->session($name) -> picture()))
        ) {
            $var->unsetSession($name);
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