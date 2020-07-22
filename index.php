<?php

require __DIR__.'/vendor/autoload.php';

require 'model/entity/Post.php';
require 'model/manager/Manager.php';
require 'model/manager/PostManager.php';
try 
{
    $post = new Post;
    dump($post);
    $post->setId('llll');
    $post->setTitle('Un nouveau depart');
    echo $post->title();
    dump($post);
    $db = new Manager;
    dump($db);
    $r = new PostManager;
    $data = $r->getPosts()->fetch();
    dump($data);
    $r1 = new PostManager;
    $data = $r1->getPost(4);
    dump($data);
    $r2 = new PostManager;
    $data = $r2->addPost('bla','bla','bla',1);
    dump($data);
}
catch(Exception $e)
{
    die('Erreur:' . $e->getCode());
}
