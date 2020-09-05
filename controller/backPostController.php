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
            $posts = $postManager -> getUserPosts($_SESSION['user']->id());
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

    public function addPostView(
        array $form=null, 
        $msg=null, 
        \model\Post $postPreview=null
    ) { 
        if ($form != null) {
            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            
            if ($newPost->id() == null) {
                $result = $postManager -> addPost($newPost);
                $this -> resultPost($result[0], $result[1]);

            } else {
                
                $result = $postManager -> updatePost($newPost);
                
                $this -> resultPost($result, $newPost->id());
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

        if ($affectedLines == 1) {
            $data = $postManager -> getPost($id);
            $newPost = new \model\Post($data);
            
            if ($newPost->published() == 'TRUE') {
        
                if (isset($_SESSION['previewPost']) 
                    && isset($_SESSION['oldImage'])
                ) {
                    if (basename($_SESSION['previewPost']->picture())  != $_SESSION['oldImage']
                    ) {
                        unlink(POST_IMG_DIRECTORY . $_SESSION['oldImage']);
                    }
                }
                $this -> deleteSession('previewPost');
                header('Location: index.php?p=post&id=' . $newPost->id());
                exit();

            } else {
                
                $_SESSION['addPostMsg'] = MSG_SAVE;
                $this -> deleteSession('previewPost');
                header('Location: index.php?admin=addpost');
                exit();
            }

        } else {
            $_SESSION['addPostMsg'] = POST_NO_OK;
            header('Location: index.php?admin=addpost');
            exit();
        }
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

    public function dataInputPost($id=null)
    {
        if (empty($_POST['titlePost'])
            && empty($_POST['chapoPost'])
            && empty($_POST['contentPost'])
        ) {
            if (isset($_SESSION['previewPost'])) {
                $_POST['titlePost'] = $_SESSION['previewPost']->title();
                $_POST['chapoPost'] = $_SESSION['previewPost']->chapo();
                $_POST['contentPost'] = $_SESSION['previewPost']->content();
            }
        }
        if (!empty($_POST['titlePost'])
            && !empty($_POST['chapoPost'])
            && !empty($_POST['contentPost'])
        ) {
            if (empty($_FILES['imgPost']['name'])) {
                
                if (isset($_SESSION['previewPost']) 
                    && $_SESSION['previewPost']->picture() != null
                ) {
                    $path = basename($_SESSION['previewPost']->picture());
                    
                    if (isset($_POST['notPublished']) || isset($_POST['addPost'])) {
                        $fileInfo = pathinfo($path);
                        $newName = (string)time() . '.' .$fileInfo['extension'];
                        if (!file_exists('tmp/')) {
                            mkdir('tmp/');
                        }
                        rename('tmp/'. $path, POST_IMG_DIRECTORY . $newName);
                        $_SESSION['previewPost'] -> setPicture(POST_IMG_DIRECTORY . $newName);
                    }
                    $path = $_SESSION['previewPost']->picture();
                    
                } else {
                    $path = null;    
                }
            } else {
                $path =  $this -> uploadFile($_FILES['imgPost']);  
            }
            $form = array(
                'id' => $id,
                'title' => $_POST['titlePost'],
                'chapo' => $_POST['chapoPost'],
                'content' => $_POST['contentPost'],
                'picture' => $path,
                'published' => 'FALSE'   
            );
            
            return $form;
            
        } else {
            $_SESSION['addPostMsg'] = EMPTY_FIELDS;
            header('Location: index.php?admin=addpost');
        }
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

            if ($post->picture() != null) {
                if (!file_exists('tmp/')) {
                    mkdir('tmp/');
                }
                if (file_exists(POST_IMG_DIRECTORY . $post->picture())) {
                    copy(POST_IMG_DIRECTORY . $post->picture(), 'tmp/' . 'tmp' . $post->picture());
                    $post->setPicture('tmp/' . 'tmp' . $post->picture());
                }
                
            }
            return $post;

        } else {
            throw new \Exception(POST_NO_EXIST); 
        }
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

    public function deletePost($id)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($id);
        $post = new \model\Post($data);

        $commentManager = new \model\CommentManager;
        $commentManager->deletePostComments($id);
        
        $affectedLines = $postManager->deletePost($id);

        if ($affectedLines == 1) {
            unlink(POST_IMG_DIRECTORY . basename($post->picture()));
            header('Location: index.php?admin=post');

        } else {
            throw new \Exception(POST_NO_SUP);
        }
    }

    public function uploadFile($imgPost=null)
    {  
        $this -> verifTmpFolder();

        if ($imgPost['error'] == 0  && $imgPost['size'] <= 2000000) {
            
            if (in_array(
                pathinfo($imgPost['name'])['extension'], AUTHORIZED_EXTENSIONS
            ) && (isset($_POST['addPost']) || isset($_POST['notPublished']))
            ) {
                move_uploaded_file(
                    $imgPost['tmp_name'], 
                    POST_IMG_DIRECTORY . basename($imgPost['name'])
                );
                rename(
                    POST_IMG_DIRECTORY . basename($imgPost['name']), 
                    POST_IMG_DIRECTORY . (string)time() . '.' 
                    . pathinfo($imgPost['name'])['extension']
                );
                return POST_IMG_DIRECTORY . (string)time() . '.' 
                . pathinfo($imgPost['name'])['extension'];

            } elseif (in_array(
                pathinfo($imgPost['name'])['extension'], AUTHORIZED_EXTENSIONS
            ) && isset($_POST['preview'])
            ) {
                move_uploaded_file(
                    $imgPost['tmp_name'], 
                    'tmp/' . basename($imgPost['name'])
                );
                return 'tmp/' . basename($imgPost['name']);
            }
            throw new \Exception(UPLOAD_NO_OK);
        } 
        throw new \Exception(UPLOAD_NO_OK);      
    }

    public function imgChange()
    {
        if (isset($_SESSION['previewPost'])) {
            if (file_exists($_SESSION['previewPost'] -> picture())) {
                unlink($_SESSION['previewPost'] -> picture());
            }
            $_SESSION['previewPost']->setPicture(null);
            $this -> addPostView($form=null, $msg=null, $_SESSION['previewPost']);
        }  
    }

    public function deleteSession($name) 
    {
        if (isset($_SESSION[$name])) {
            if (file_exists($_SESSION[$name] -> picture())) {
                $postManager = new \model\PostManager;
                $result = $postManager -> getPostImg(basename($_SESSION[$name] -> picture()));
                if ($result == 0) {
                    unlink($_SESSION[$name] -> picture());
                } 
            }
            unset($_SESSION[$name]);
        }
    }

    public function verifTmpFolder()
    {
        if (!file_exists('tmp/')) {
            mkdir('tmp/');
        }
    }
}