<?php

class FrontController extends Controller 
{ 

    private $_msg;

    public function msg()
    {
        return $this->_msg;
    }

    public function homePage()
    {
        $postManager = new PostManager;
        $posts = $postManager -> getPosts(3);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'posts' => $posts
            )
        );
    }

    public function homePageMsg($msg)
    {
        $postManager = new PostManager;
        $posts = $postManager -> getPosts(3);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'posts' => $posts,
                'msg' => $msg   
            )
        );
    }

    public function listPostsView()
    {
        $postManager = new PostManager;
        $nbrPosts = $postManager -> countPosts();
        $posts = $postManager -> getPosts($nbrPosts, 0);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/listPostView.twig', array(
                'posts' => $posts
            )
        );
    }

    public function postView($id)
    {
        $postManager = new PostManager;
        $dataPost = $postManager -> getPost($id); 

        $post = new Post($dataPost);

        $commentManager = new CommentManager;
        $dataComment = $commentManager -> getComments($id);
        $nbrComments = $commentManager -> nbrComments($id);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text());

        echo $this->twig->render(
            'frontView/postView.twig', array(
                'post' => $post,
                'comments' => $dataComment,
                'nbrComments' => $nbrComments['COUNT(*)']
            )
        );
    }

    public function sendMessage(array $form)
    {
        foreach ($form as $key => $value) {
            $form[$key] = htmlspecialchars($form[$key]);
        }

        $message = new Message($form);
        $mail = $message -> sendMessage();

        if ($mail) {
            $msg = MSG_OK;
        } else {
            $msg = MSG_NO_OK;
        }
        $this->_msg = $msg;
    }


}