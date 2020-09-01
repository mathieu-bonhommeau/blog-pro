<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackUserController extends BackController
{
    public function addUserView($form=null)
    {
        if (isset($_SESSION['addUserMsg'])) {
            $msg = $_SESSION['addUserMsg'];
            unset($_SESSION['addUserMsg']);
        } else {
            $msg = null;
        }

        if ($form != null) {
            $updateUser = new \model\User($form);
        } else {
            $updateUser = null;
        }

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'backView/addUserView.twig', array(
                'user' => $this->user,
                'msg' => $msg,
                'updateUser' => $updateUser   
            )
        );
    }

    public function addUser($form)
    {
        $userManager = new \model\UserManager;
        $user = new \model\User($form);
        
        return $userManager -> addUser($user); 
        

    }

    public function listUsers()
    {
        $userManager = new \model\UserManager;
        $users = $userManager -> getUsers();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'backView/backListUserView.twig', array(
                'user' => $this->user,
                'users' => $users  
            )
        );
    }

    public function getUpdateUser($id)
    {
        $userManager = new \model\UserManager;
        $data = $userManager -> getUser((int)$id);
        if ($data != false) {
            return $data;
        } else {
            throw new \Exception(USER_NO_EXIST);
        }
          
    }

    public function updateUser($form)
    {
        $userManager = new \model\UserManager;
        $user = new \model\User($form);

        return $userManager -> updateUser($user);
    }

    public function deleteUserView($id)
    {
        $userManager = new \model\UserManager;
        $postManager = new \model\PostManager;

        $data = $userManager -> getUser((int)$id);
        $posts = $postManager -> getUserPosts($id);

        $deleteUser = new \model\User($data);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/deleteUserView.twig', array(
                'user' => $this->user,
                'deleteUser' => $deleteUser,
                'posts' => $posts 
            )
        );
        
    }

    public function deleteUser($id)
    {
        $userManager = new \model\UserManager;
        return $userManager -> deleteUser($id);
    }

}