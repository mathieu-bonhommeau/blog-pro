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
        $postManager = new PostManager();
        $post1 = $postManager -> getPosts(1, 0);
        $post2 = $postManager -> getPosts(1, 1);
        $post3 = $postManager -> getPosts(1, 2);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'post1' => $post1, 
                'post2' => $post2, 
                'post3' => $post3
                
            )
        );

    }

    public function homePageMsg($msg)
    {
        $postManager = new PostManager();
        $post1 = $postManager -> getPosts(1, 0);
        $post2 = $postManager -> getPosts(1, 1);
        $post3 = $postManager -> getPosts(1, 2);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'post1' => $post1, 
                'post2' => $post2, 
                'post3' => $post3,
                'msg' => $msg
                
            )
        );

    }

    public function listPostsView()
    {
        echo $this->twigInit()->render('frontView/listPostView.twig');
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