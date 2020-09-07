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
        if (!empty($_POST['inputName']) 
            && !empty($_POST['inputFirstName']) 
            && !empty($_POST['inputEmail']) 
            && !empty($_POST['inputMessage'])
        ) {
            $form = array('inputName' => $_POST['inputName'], 
                    'inputFirstName' => $_POST['inputFirstName'], 
                    'inputEmail' => $_POST['inputEmail'], 
                    'inputMessage' => filter_input(
                        INPUT_POST, 'inputMessage', 
                        FILTER_SANITIZE_SPECIAL_CHARS
                    )
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
        $backManageComment = null;
        if (isset($_GET['c'])) {
            $backManageComment = $_GET['c'];
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
        $backCommentController = new \controller\BackCommentController;

        if (isset($_GET['cid'])) {      
            $backCommentController -> updateComment(
                filter_input(
                    INPUT_GET, 'cid',
                    FILTER_SANITIZE_SPECIAL_CHARS
                )
            );
            return;
        }
    }

    public function testInputComment($valid, $moderate=null)
    {
        $frontController = new \controller\FrontController;

        $userId = null;
        $userType = null;

        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']->userId();
        } 

        if ($moderate != null) {
            $userType = $_SESSION['user']->type() . ' : ';
        }

        if (!empty($_POST['nameVisitor']) 
            && !empty($_POST['emailVisitor']) 
            && !empty($_POST['content'])
        ) {                           
            $form = array(
                'nameVisitor' => $userType . $_POST['nameVisitor'],
                'emailVisitor' => $_POST['emailVisitor'],
                'content' => $_POST['content'],
                'validComment' => $valid,
                'user_id' => $userId,
                'post_id' =>$_GET['id']
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
        if (!empty($_POST['inputPseudoConnect']) 
            && !empty($_POST['inputPasswordConnect'])
        ) {
            $msgConnect = $this -> verifyUser(
                $_POST['inputPseudoConnect'], 
                $_POST['inputPasswordConnect']    
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
        
        $userManager = new \model\UserManager;
        $data = $userManager -> getUser($pseudo);
        
        if ($data) {
            $user = new \model\User($data);
        } else {
            return  USER_NO_OK; 
        }

        if (!isset($_GET['admin']) && password_verify(
            $password, $user->password()
        )         
        ) {
            $_SESSION['user'] = $user;
            header('Location: index.php?p=home');
            exit();
        }

        if (($_GET['admin'] == 'adduser' && $password == $user->password())
        ) {
            $_SESSION['user'] = $user;
            header('Location: index.php?p=home');
            exit();
        } 
             
    }
}