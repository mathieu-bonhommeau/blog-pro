<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackUserController extends BackController
{
    public function addUserView($form=null)
    {
        /*if ($form != null) {
            $newPost = new \model\Post($form);
            $postManager = new \model\PostManager;
            
            if ($newPost->id() == null) {
                $result = $postManager -> addPost($newPost);
                $this -> resultPost($result[0], $result[1]);

            } else {
                $result = $postManager -> updatePost($newPost);
                $this -> resultPost($result, $newPost->id());
            }
        }*/
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'backView/addUserView.twig', array(
                'user' => $this->user
                 
            )
        );
    }
}