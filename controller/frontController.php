<?php

namespace controller;

use Faker\ValidGenerator;
use Twig;
use Twig_Extensions_Extension_Text;

class FrontController extends Controller 
{ 
    
    public function homePage($msg=null)
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getHomePosts(3);

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/homeView.twig', array(
                'posts' => $posts,
                'msg' => $msg,
                'user' => $this->user 
            )
        );
    }

    public function testInputMessage()
    {
        $var = new \config\GlobalVar;

        if ($var->noEmptyPost('inputName')
            && $var->noEmptyPost('inputFirstName') 
            && $var->noEmptyPost('inputEmail') 
            && $var->noEmptyPost('inputMessage')
        ) {
            $form = array('inputName' => $var->post('inputName'), 
                    'inputFirstName' => $var->post('inputFirstName'), 
                    'inputEmail' => $var->post('inputEmail'), 
                    'inputMessage' => $var->post('inputMessage')       
            );
            return $form;
        }
        return EMPTY_FIELDS;
    }

    public function runSendMessage($form)
    {
        $controller = new \controller\Controller;
        if ($form == EMPTY_FIELDS) {
            return EMPTY_FIELDS;
        }
        $controller -> sendMessage($form, SUPPORT_EMAIL);
        $msg = $controller -> msg();
        return $msg;
    }

    public function listPostsView()
    {
        $postManager = new \model\PostManager;
        $posts = $postManager -> getPosts();

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'frontView/listPostView.twig', array(
                'posts' => $posts,
                'user' => $this->user
            )
        );
    }

    public function postView($postId, $msg=null)
    {
        $var = new \config\GlobalVar;

        $backManageComment = null;

        if ($var->issetGet('c')) {
            $backManageComment = $var->get('c');
        } 
        $postManager = new \model\PostManager;
        $dataPost = $postManager -> getPost($postId);

        if (!$dataPost) {  
            throw new \Exception(PAGE_NOT_EXIST);  
        }

        $post = new \model\Post($dataPost);
        
        if ($post->published() == 'FALSE' && $backManageComment != 'valid'
            && $backManageComment != 'ok' && $backManageComment != 'moderate'
            && $backManageComment != 'list'
        ) {
            throw new \Exception(PAGE_NOT_EXIST);
        } 

        $commentManager = new \model\CommentManager;
        $dataComment = $commentManager -> getComments($postId);
        $nbrComments = $commentManager -> nbrComments($postId, 'TRUE');
        $this->twigInit();
        $this->twig->addExtension(new Twig_Extensions_Extension_Text());
        echo $this->twig->render(
            'frontView/postView.twig', array('post' => $post, 
            'comments' => $dataComment,'nbrComments' => $nbrComments['COUNT(*)'],
            'commentMsg' => $msg, 'user' => $this->user,
            'backManageComment' => $backManageComment
            )
        );   
    }

    public function addNewComment(array $form)
    {
        $comment = new \model\Comment($form);

        $commentManager = new \model\CommentManager;
        $affectedLines = $commentManager -> addComment($comment);

        if ($affectedLines == 1) {
            return WAIT_VALID_COMMENT;
        } else {
            return MSG_NO_OK;
        }
    }

    public function validComment()
    {
        $var = new \config\GlobalVar;
        $backCommentController = new \controller\BackCommentController;

        if ($var->issetGet('cid')) {      
            $backCommentController -> updateComment($var->get('cid'));
            return;
        }
    }

    public function testInputComment($valid, $moderate=null)
    {
        $var = new \config\GlobalVar;
        $frontController = new \controller\FrontController;

        $userId = null;
        $userType = null;

        if ($var->issetSession('user')) {
            $userId = $var->session('user')->userId();
        } 

        if ($moderate != null) {
            $userType = $var->session('user')->type() . ' : ';
        }

        if ($var->noEmptyPost('nameVisitor') 
            && $var->noEmptyPost('emailVisitor') 
            && $var->noEmptyPost('content')
        ) {                           
            $form = array(
                'nameVisitor' => $userType . $var->post('nameVisitor'),
                'emailVisitor' => $var->post('emailVisitor'),
                'content' => $var->post('content'),
                'validComment' => $valid,
                'user_id' => $userId,
                'post_id' =>$var->get('id')
            );           
            return $this -> addNewComment($form);              
        } 
        return EMPTY_FIELDS;             
    }

    public function connectView($msg=null)
    {
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        echo $this->twig->render(
            'frontView/connectView.twig', array(
                'user' => $this->user,
                'msg' => $msg
            )
        );

    }

    public function testInputConnect()
    {
        $var = new \config\GlobalVar;

        if ($var->noEmptyPost('inputPseudoConnect') 
            && $var->noEmptyPost('inputPasswordConnect')
        ) {
            $msgConnect = $this -> verifyUser(
                $var->post('inputPseudoConnect'), 
                $var->post('inputPasswordConnect')    
            );
            return $msgConnect;
            
        } else {

            $msgConnect = EMPTY_FIELDS;
            $this -> connectView($msgConnect);
            return;
        }
    }

    public function verifyUser($pseudo, $password)
    {
        $var = new \config\GlobalVar;

        $userManager = new \model\UserManager;
        $data = $userManager -> getUser($pseudo);
        
        if ($data) {
            $user = new \model\User($data);
        } else {
            return  USER_NO_OK; 
        }

        if (!$var->issetGet('admin') && password_verify(
            $password, $user->password()
        )         
        ) {
            $var -> setSession('user', $user);
            $var -> unsetSession('msg');
            header('Location: index.php?p=home');
            exit();
        }

        if (($var->get('admin') == 'adduser' && $password == $user->password())
        ) {
            $var -> setSession('user', $user);
            $var -> unsetSession('msg');
            header('Location: index.php?p=home');
            exit();
        } 
             
    }
}