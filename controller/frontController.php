<?php

class FrontController extends Controller 
{ 
    public function home()
    {
        $postManager = new PostManager();
        $datas = $postManager -> getPosts();
        $posts = $datas ->fetchAll();
        dump($posts);

        echo $this->twigInit()->render(
            'frontView/homeView.twig',
            ['post' => $posts, 
             'nom' => 'Mathieu']
        );
        
    }

    public function listPostsView()
    {
        echo $this->twigInit()->render('frontView/listPostView.twig');
    }
}