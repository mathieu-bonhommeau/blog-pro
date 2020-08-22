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
        $lastPost = $postManager -> getPosts(1);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backHomeView.twig', array(
                'user' => $this->user,
                'nbrPosts' => $nbrPosts,
                'lastPost' => $lastPost
            )
        );
    }

    public function backListPosts()
    {
        $postManager = new \model\PostManager;
        $nbrPosts = $postManager -> countPosts();
        $posts = $postManager -> getPosts($nbrPosts);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/backListPostView.twig', array(
                'user' => $this->user,
                'posts' => $posts
                
            )
        );
    }

    public function addPost(array $form=null, $msg=null, \model\Post $postPreview=null)
    {
        if ($form != null) {

            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            $result = $postManager -> addPost($newPost);

            if ($result[0] == 1) {
                $data = $postManager -> getPost($result[1]);
                $newPost = new \model\Post($data);
                header('Location: index.php?p=post&id=' . $newPost->id());
                exit();

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

    public function uploadFile($imgPost)
    {
        if ($imgPost['error'] == 0  && $imgPost['size'] <= 2000000 ) {
            $fileInfo = pathinfo($imgPost['name']);

            if (in_array($fileInfo['extension'], AUTHORIZED_EXTENSIONS)) {
                if (isset($_POST['addPost'])) {

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
}