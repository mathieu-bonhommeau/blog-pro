<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackController extends Controller
{
    public function backHomePage()
    {
        $postManager = new \model\PostManager;
        $nbrPosts = $postManager -> countPosts();
        $lastDatePost = $postManager -> lastDatePost();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backHomeView.twig', array(
                'user' => $this->user,
                'nbrPosts' => $nbrPosts,
                'lastDatePost' => $lastDatePost
            )
        );
    }

    public function backListPosts()
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getPosts();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backListPostView.twig', array(
                'user' => $this->user,
                'posts' => $posts
                
            )
        );
    }

    public function addPost(
        array $form=null, 
        $msg=null, 
        \model\Post $postPreview=null
    ) { 

        if ($form != null) {

            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            $result = $postManager -> addPost($newPost);
            
            if ($result[0] == 1) {
                $data = $postManager -> getPost($result[1]);
                $newPost = new \model\Post($data);
                
                if ($newPost->published() == 'TRUE') {
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
        if (!empty($_POST['titlePost'])
            && !empty($_POST['chapoPost'])
            && !empty($_POST['contentPost'])
        ) {
            if (empty($_FILES['imgPost']['name'])) {
                if (isset($_SESSION['previewPost'])) {
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
                'picture' => $path
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
            if ($affectedLine == 1) {
                header('Location: index.php?admin=post');

            } else {
                throw new \Exception(POST_NO_OK);
            }
        } else {
            throw new \Exception(POST_NO_EXIST);
        }
    }

    public function updatePost($id)
    {
        $postManager = new \model\PostManager;
        $data = $postManager -> getPost($id);
        
        if ($data) {
            $post = new \model\Post($data);

            if ($post->picture() != null) {
                $_SESSION['oldImg'] = $post->picture();
                
                copy(POST_IMG_DIRECTORY . $post->picture(), 'tmp/' . $post->picture());
                $post->setPicture('tmp/' . $post->picture());
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
            $dataComment = $commentManager -> getComments($id);
            $nbrComments = $commentManager -> nbrComments($id);

            $this->twigInit();
            $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
            $this->twig->addExtension(new Twig_Extensions_Extension_Text());

            echo $this->twig->render(
                'backView/deleteView.twig', array(
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
            unlink(POST_IMG_DIRECTORY . $post->picture());
            header('Location: index.php?admin=post');

        } else {
            throw new \Exception(POST_NO_SUP);
        }
    }

    public function uploadFile($imgPost)
    {
        if ($imgPost['error'] == 0  && $imgPost['size'] <= 2000000 ) {
            $fileInfo = pathinfo($imgPost['name']);

            if (in_array($fileInfo['extension'], AUTHORIZED_EXTENSIONS)) {

                if (isset($_POST['addPost']) || isset($_POST['notPublished'])) {

                    $new = move_uploaded_file(
                        $imgPost['tmp_name'], 
                        POST_IMG_DIRECTORY . basename($imgPost['name'])
                    );

                    rename(POST_IMG_DIRECTORY . basename($imgPost['name']), POST_IMG_DIRECTORY . (string)time() . '.' .$fileInfo['extension']);

                    return POST_IMG_DIRECTORY . (string)time() . '.' . $fileInfo['extension'];

                } elseif (isset($_POST['preview'])) {

                    $new = move_uploaded_file(
                        $imgPost['tmp_name'], 
                        'tmp/' . basename($imgPost['name'])
                    );
                    return 'tmp/' . basename($imgPost['name']);
                }
                

            } else {
                throw new \Exception(UPLOAD_NO_OK);
            }

        } else {
            throw new \Exception(UPLOAD_NO_OK);
        }
    }

    public function imgChange()
    {
        if (isset($_SESSION['previewPost'])) {
            unlink($_SESSION['previewPost'] -> picture());
            $_SESSION['previewPost']->setPicture(null);
            $this -> addPost($form=null, $msg=null, $_SESSION['previewPost']);
        }  
    }

    public function deleteSession($name) 
    {
        if (isset($_SESSION[$name])) {
            if (file_exists($_SESSION[$name] -> picture())) {
                unlink($_SESSION[$name] -> picture());
            }
            
            unset($_SESSION[$name]);
        }
    }
}