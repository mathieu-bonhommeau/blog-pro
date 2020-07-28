<?php

class FrontController extends Controller 
{ 
    public function homePage()
    {
        $postManager = new PostManager();
        $datas = $postManager -> getPosts(3);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'frontView/homeView.twig', array('posts' => $datas)
        );
        
    }

    public function listPostsView()
    {
        echo $this->twigInit()->render('frontView/listPostView.twig');
    }
}