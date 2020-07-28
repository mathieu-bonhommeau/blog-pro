<?php

class FrontController extends Controller 
{ 
    public function homeView()
    {
        $postManager = new PostManager();
        $datas = $postManager -> getPosts();

        echo $this->twigInit()->render(
            'frontView/homeView.twig',
            array('post' => $datas)
        );
        
    }

    public function listPostsView()
    {
        echo $this->twigInit()->render('frontView/listPostView.twig');
    }
}