<?php

require __DIR__.'/vendor/autoload.php';

require 'model/entity/Post.php';
require 'model/manager/Manager.php';
require 'model/manager/PostManager.php';
require 'model/manager/CommentManager.php';
require 'model/entity/Comment.php';
require 'model/manager/UserManager.php';
try 
{
    $postManager = new PostManager;
    $data = $postManager->addPost('bla', 'bla', 'bla', 1);
    $data = $postManager -> getPost(14);
    $post = new Post($data);
    dump($post);
    echo $post->lastDateModif();
    $commentManager = new CommentManager;
    $datas = $commentManager -> getComment(2);
    dump($datas);
    $comment = new Comment($datas);
    dump($comment);
    $userManager = new UserManager;
    $data = $userManager->addUser('Anna', 'coucou', '',  'Annabelle', 4);

    

    

}
catch(Exception $e)
{
    die('Erreur:' . $e->getCode() . $e->getMessage());
}
