<?php

class FrontController extends Controller 
{ 
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

    public function listPostsView()
    {
        echo $this->twigInit()->render('frontView/listPostView.twig');
    }
}