<?php

/**
 * This file contains BackUserController class
 */
namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for get users data and send it back to views
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackUserController extends BackController
{

    /**
     * Retrives and send data to addUser page
     * 
     * @param array $form Null if add a new user
     *                    Array with user data if update a user
     * 
     * @return void 
     */
    public function addUserView($form=null)
    {
        $var = new \config\GlobalVar;

        $msg = null;
        $updateUser = null;

        if ($var->issetSession('addUserMsg')) {
            $msg = $var->session('addUserMsg');
            $var->unsetSession('addUserMsg');
        } 

        if ($form != null) {
            $updateUser = new \model\User($form);
        } 
        
        $var->setSession('updateUser', $updateUser);

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

    /**
     * Create a user object for add a user in database
     * 
     * @param array $form Array with inputs adduser form
     * 
     * @return int Number of affected lines in database 
     */
    public function addUser($form)
    {
        $userManager = new \model\UserManager;
        $user = new \model\User($form);
        
        return $userManager -> addUser($user); 
    }

    /**
     * Test inputs in adduser form on adduser page
     * 
     * @return void
     */
    public function testAdduser()
    {
        $var = new \config\GlobalVar;

        if ($var->post('userPassword') != $var->post('userPasswordConfirm')) {
            $var->setSession('addUserMsg', USER_NO_OK);
            header('Location: index.php?admin=adduser');
            exit();
        }

        if ($var->issetGet('id') && $var->issetSession('updateUser')) {
            
            $affectedLine = $this -> testUpdateUser();

        } else {
            $form = array(
                'userName' => $var->post('userName'),
                'password' => password_hash(
                    $var->post('userPassword'), 
                    PASSWORD_DEFAULT
                ),
                'type' => $var->post('userType') 
            );
            $affectedLine = $this -> addUser($form);
        }
            
        if ($affectedLine == 1 ) {
            $var->setSession('addUserMsg', ADD_USER_OK);
            header('Location: index.php?admin=adduser');
            exit();
        } 
        $var->setSession('addUserMsg', ADD_USER_NO_OK);
        header('Location: index.php?admin=adduser');
        exit();   
    }

    /**
     * Test inputs in adduser form on adduser page when update a user
     * 
     * @return int Number of affected lines 
     */
    public function testUpdateUser()
    {
        $frontController = new \controller\FrontController;
        $var = new \config\GlobalVar;

        $form = array(
            'id' => $var->get('id'),
            'userName' => $var->post('userName'),
            'password' => $var->post('userPassword'),
            'userEmail' => $var->session('updateUser')->userEmail(),
            'profilPicture' => $var->session('updateUser')->profilPicture(),
            'authorName' => $var->session('updateUser')->authorName(),
            'type' => $var->post('userType') 
        );
          
        $var->unsetSession('updateUser');
        $affectedLine = $this -> updateUser($form);
         
        if ($var->session('user')->userId() == $var->get('id')) { 
            
            $frontController -> verifyUser(
                $var->post('userName'), 
                $var->post('userPassword')
            );
            header('Location: index.php?admin=backhome');
            exit();
        }
        return $affectedLine;
    }

    /**
     * Retrieves and send data to list users page
     * 
     * @return void
     */
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

    /**
     * Retrieves data user for update a user
     * 
     * @param int $userId 
     * 
     * @return array User data
     */
    public function getUpdateUser($userId)
    {
        $userManager = new \model\UserManager;
        $data = $userManager -> getUser((int)$userId);
        if ($data != false) {
            return $data;
        } else {
            throw new \Exception(USER_NO_EXIST);
        }    
    }

    /**
     * Retrieves inputs in addUser form on addUser page for update a user
     * 
     * @param array $form Inputs in adduser form
     * 
     * @return int Number of affected lines
     */
    public function updateUser($form)
    {
        $userManager = new \model\UserManager;
        $user = new \model\User($form);
        return $userManager -> updateUser($user);
    }

    /**
     * Retrieves and send data user to delete user page
     * 
     * @param int $userId Id of user
     * 
     * @return void
     */
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

    /**
     * Delete user 
     * 
     * @param int $userId Id of user
     * 
     * @return void 
     */
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

    /**
     * Retrieves and send data user to profil page
     * 
     * @param int   $userId Id of user
     * @param mixed $update Int $update=1 for modify profil inputs
     *                      else Null inputs are on ReadOnly
     * 
     * @return void
     */
    public function profilView($userId, $update=null)
    {
        $var = new \config\GlobalVar;
        $userManager = new \model\UserManager;

        $data = $userManager -> getUser((int)$userId);
        $userProfil = new \model\User($data);

        if ($var->issetSession('updateUserMsg')) {
            $msg = $var->session('updateUserMsg');
            $var->unsetSession('updateUserMsg');
        } else {
            $msg = null;
        }

        if ($var->issetSession('resetImage')
            && $var->session('resetImage') == 'reset'
        ) {
            $userProfil->setprofilPicture(null);
            $var->unsetSession('resetImage');
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

    /**
     * Test inputs in profil form
     * 
     * @return void
     */
    public function dataInputProfil()
    {
        $var = new \config\GlobalVar;
        $frontController = new \controller\FrontController;

        $userEmail = null;
        $authorName = null;
        $profilPicture = null;
        
        if ($var->post('userPassword') == $var->post('userPasswordConfirm')) {
            if ($var->issetPost('userEmail')) {
                $userEmail = $var->post('userEmail');
            } 
            if ($var->issetPost('authorName')) {
                $authorName = $var->post('authorName');
            } 
            if (isset($_FILES['profilPictureUpload'])
                && $_FILES['profilPictureUpload']['name'] != null
            ) {
                $profilPicture = $this ->
                uploadProfilPicture(
                    $_FILES['profilPictureUpload']
                ); 
            } elseif ($var->issetPost('profilPictureUpload')) {
                $profilPicture = $var->post('profilPictureUpload');
            } 
            
            $form = array(
                'id' => $var->get('id'),
                'userName' => $var->post('userName'),
                'password' =>  password_hash(
                    $var->post('userPassword'),
                    PASSWORD_DEFAULT
                ),
                'userEmail' => $userEmail,
                'authorName' => $authorName,
                'profilPicture' => basename($profilPicture),
                'type' => $var->session('user')->type()
            );
            
            $this -> updateUser($form);
            $frontController -> verifyUser(
                $var->post('userName'), $var->post('userPassword')
            );
            return;
        }
        $var->setSession('updateUserMsg', USER_NO_OK);
        header('Location: index.php?admin=profil&id=' . $var->get('id'));
        exit();
    }

    /**
     * Upload profil picture in profil form
     * 
     * @param string $picture Picture name
     * 
     * @return string Picture full name - path of file
     */
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

    /**
     * Delete old profil picture when change
     * 
     * @return void
     */
    public function deleteOldProfilPicture() 
    {
        $var = new \config\GlobalVar;

        if (!empty($var->session('user')->profilPicture()) 
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