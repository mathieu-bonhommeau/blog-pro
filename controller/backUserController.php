<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackUserController extends BackController
{
    public function addUserView($form=null)
    {
        $msg = null;
        $updateUser = null;

        if (isset($_SESSION['addUserMsg'])) {
            $msg = $_SESSION['addUserMsg'];
            unset($_SESSION['addUserMsg']);
        } 

        if ($form != null) {
            $updateUser = new \model\User($form);
        } 
        
        $_SESSION['updateUser'] = $updateUser;

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

    public function testAdduser()
    {
        if ($_POST['userPassword'] != $_POST['userPasswordConfirm'] ) {
            $_SESSION['addUserMsg'] = USER_NO_OK;
            header('Location: index.php?admin=adduser');
            exit();
        }

        if (isset($_GET['id']) && isset($_SESSION['updateUser'])) {
            
            $affectedLine = $this -> testUpdateUser();

        } else {
            $form = array(
                'userName' => $_POST['userName'],
                'password' => password_hash(
                    $_POST['userPassword'], 
                    PASSWORD_DEFAULT
                ),
                'type' => $_POST['userType'] 
            );
            $affectedLine = $this -> addUser($form);
        }
            
        if ($affectedLine == 1 ) {
            $_SESSION['addUserMsg'] = ADD_USER_OK;
            header('Location: index.php?admin=adduser');
            exit();
        } 
        $_SESSION['addUserMsg'] = ADD_USER_NO_OK;
        header('Location: index.php?admin=adduser');
        exit();   
    }

    public function testUpdateUser()
    {
        $frontController = new \controller\FrontController;
        
        $form = array(
            'id' => $_GET['id'],
            'userName' => $_POST['userName'],
            'password' => $_POST['userPassword'],
            'userEmail' => $_SESSION['updateUser']->userEmail(),
            'profilPicture' => $_SESSION['updateUser']->profilPicture(),
            'authorName' => $_SESSION['updateUser']->authorName(),
            'type' => $_POST['userType'] 
        );
          
        unset($_SESSION['updateUser']);
        $affectedLine = $this -> updateUser($form);
         
        if ($_SESSION['user']->userId() == $_GET['id']) { 
            
            $frontController -> verifyUser(
                $_POST['userName'], 
                $_POST['userPassword']
            );
            header('Location: index.php?admin=backhome');
            exit();
        }
        return $affectedLine;
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

    public function deleteUserView($userId)
    {
        $userManager = new \model\UserManager;
        $postManager = new \model\PostManager;

        $data = $userManager -> getUser((int)$userId);
        $posts = $postManager -> getUserPosts($userId);

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

    public function deleteUser($userId)
    {
        $var = new \config\GlobalVar;
        $userManager = new \model\UserManager;

        if ($var->issetPost('validDeleteUser')) {

            $affectedLine = $userManager->deleteUser($userId);

            if ($affectedLine == 1) {
                header('Location: index.php?admin=listusers');
                exit();
            }
            throw new \Exception(USER_NO_DELETE);
        }  
        $this -> deleteUserView($userId);
        return;
    }

    public function profilView($userId, $update=null)
    {
        $userManager = new \model\UserManager;
        $data = $userManager -> getUser((int)$userId);
        $userProfil = new \model\User($data);

        if (isset($_SESSION['updateUserMsg'])) {
            $msg = $_SESSION['updateUserMsg'];
            unset($_SESSION['updateUserMsg']);
        } else {
            $msg = null;
        }

        if (isset($_SESSION['resetImage'])
            && $_SESSION['resetImage'] == 'reset'
        ) {
            $userProfil->setprofilPicture(null);
            unset($_SESSION['resetImage']);
        }

        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line

        echo $this->twig->render(
            'backView/profilView.twig', array(
                'user' => $this->user,
                'userProfil' => $userProfil,
                'update' => $update,
                'msg' => $msg
                
            )
        );
    }

    public function dataInputProfil()
    {
        $frontController = new \controller\FrontController;

        $userEmail = null;
        $authorName = null;
        $profilPicture = null;
        
        if ($_POST['userPassword'] == $_POST['userPasswordConfirm']) {
            if (isset($_POST['userEmail'])) {
                $userEmail = $_POST['userEmail'];
            } 
            if (isset($_POST['authorName'])) {
                $authorName = $_POST['authorName'];
            } 
            if (isset($_FILES['profilPictureUpload'])
                && $_FILES['profilPictureUpload']['name'] != null
            ) {
                $profilPicture = $this ->
                uploadProfilPicture(
                    $_FILES['profilPictureUpload']
                ); 
            } elseif (isset($_POST['profilPictureUpload'])) {
                $profilPicture = $_POST['profilPictureUpload'];
            } 
            
            $form = array(
                'id' => $_GET['id'],
                'userName' => $_POST['userName'],
                'password' =>  password_hash(
                    $_POST['userPassword'],
                    PASSWORD_DEFAULT
                ),
                'userEmail' => $userEmail,
                'authorName' => $authorName,
                'profilPicture' => basename($profilPicture),
                'type' => $_SESSION['user']->type()
            );
            
            $this -> updateUser($form);
            $frontController -> verifyUser(
                $_POST['userName'], $_POST['userPassword']
            );
            return;
        }
        $_SESSION['updateUserMsg'] = USER_NO_OK;
        header('Location: index.php?admin=profil&id=' . $_GET['id']);
        exit();
    }

    public function uploadProfilPicture($picture)
    {
        $this -> deleteOldProfilPicture();

        if ($picture['error'] == 0 && $picture['size'] <= 2000000
            && (in_array(
                pathinfo($picture['name'])['extension'], AUTHORIZED_EXTENSIONS
            ))
        ) {
            move_uploaded_file(
                $picture['tmp_name'], 
                USER_IMG_DIRECTORY . basename($picture['name'])
            );
            rename(
                USER_IMG_DIRECTORY . basename(
                    $picture['name']
                ), USER_IMG_DIRECTORY . (string)time() 
                    . '.' .pathinfo($picture['name'])['extension']
            );
            return USER_IMG_DIRECTORY . (string)time() . '.' 
                . pathinfo($picture['name'])['extension'];
        } else {
            throw new \Exception(UPLOAD_NO_OK);
        }
    }

    public function deleteOldProfilPicture() 
    {
        if (!empty($_SESSION['user']->profilPicture()) 
            && (file_exists(
                USER_IMG_DIRECTORY . basename($_SESSION['user']->profilPicture())
            ))
        ) {
            unlink(
                USER_IMG_DIRECTORY . basename($_SESSION['user']->profilPicture())
            );
        }
    }
}