<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class FrontController extends Controller 
{ 

    private $_msg;



    public function msg()
    {
        return $this->_msg;
    }

    public function homePage($msg=null)
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getHomePosts(3);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'posts' => $posts,
                'msg' => $msg,
                'user' => $this->user 
            )
        );
    }

    public function listPostsView()
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getPosts();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/listPostView.twig', array(
                'posts' => $posts,
                'user' => $this->user
            )
        );
    }

    public function postView($id, $msg=null)
    {
        if (isset($_GET['c'])) {
            $backManageComment = $_GET['c'];
        } else {
            $backManageComment = null;
        }

        $postManager = new \model\PostManager;
        $dataPost = $postManager -> getPost($id); 

        if ($dataPost == false) {
            throw new \Exception(PAGE_NOT_EXIST);

        } else {
            $post = new \model\Post($dataPost);

            if ($post->published() == 'FALSE' 
                && $backManageComment != 'valid'
                
            ) {
                throw new \Exception(PAGE_NOT_EXIST);

            } else {
                $commentManager = new \model\CommentManager;
                $dataComment = $commentManager -> getComments($id);
                $nbrComments = $commentManager -> nbrComments($id, 'TRUE');

                $this->twigInit();
                $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
                $this->twig->addExtension(new Twig_Extensions_Extension_Text());

                echo $this->twig->render(
                    'frontView/postView.twig', array(
                        'post' => $post,
                        'comments' => $dataComment,
                        'nbrComments' => $nbrComments['COUNT(*)'],
                        'commentMsg' => $msg,
                        'user' => $this->user,
                        'backManageComment' => $backManageComment
                    )
                );
            }
        }      
    }

    public function sendMessage(array $form)
    {
        foreach ($form as $key => $value) {
            $form[$key] = htmlspecialchars($form[$key]);
        }

        $message = new \model\Message($form);
        $mail = $message -> sendMessage();

        if ($mail) {
            $msg = MSG_OK;
        } else {
            $msg = MSG_NO_OK;
        }
        $this->_msg = $msg;
    }

    public function addNewComment(array $form)
    {
        $comment = new \model\Comment($form);

        $commentManager = new \model\CommentManager;
        $affectedLines = $commentManager -> addComment($comment);

        if ($affectedLines == 1) {
            return WAIT_VALID_COMMENT;
        } else {
            return MSG_NO_OK;
        }
    }

    public function connectView($msg=null)
    {
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'frontView/connectView.twig', array(
                'user' => $this->user,
                'msg' => $msg
            )
        );

    }

    public function verifyUser($pseudo, $password)
    {
        $userManager = new \model\UserManager;
        $data = $userManager -> getUser($pseudo);

        if ($data) {

            $user = new \model\User($data);

            if ($user -> password() == $password) {

                $_SESSION['user'] = $user;

                header('Location: index.php?p=home');
                exit();

            } else {
                return USER_NO_OK;
            }

        } else {
            return  USER_NO_OK;
        }
    }


}