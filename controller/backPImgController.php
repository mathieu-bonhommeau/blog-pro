<?php

/**
 * This file contains BackPImgController class
 */
namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for manage post image
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class BackPImgController extends BackPostController
{
    /**
     * Test and manage upload post image
     * 
     * @param string $imgPost Name of picture post if exist
     * 
     * @return string Path of picture post
     */
    public function uploadFile($imgPost=null)
    {  
        $var = new \config\GlobalVar;

        $this -> verifTmpFolder();

        if (!($imgPost['error'] == 0  && $imgPost['size'] <= 2000000)) {
            throw new \Exception(UPLOAD_NO_OK);
        }
        if (!in_array(pathinfo($imgPost['name'])['extension'], AUTHORIZED_EXTENSIONS)
        ) {
            throw new \Exception(UPLOAD_NO_OK);
        }

        if ($var->issetPost('addPost') || $var->issetPost('notPublished')
        ) {
            $this -> moveFile($imgPost, POST_IMG_DIRECTORY);
            $this -> renameFile($imgPost, POST_IMG_DIRECTORY);
            return POST_IMG_DIRECTORY . (string)time() . '.' 
            . pathinfo($imgPost['name'])['extension'];
        } 
        
        if ($var->issetPost('preview')
        ) {
            $this -> moveFile($imgPost, 'tmp/');
            return 'tmp/' . basename($imgPost['name']);
        }      
    }

    /**
     * Move file for save upload file in definity folder
     * 
     * @param string $imgPost   Name of picture post
     * @param string $directory Destination directory of picture post
     * 
     * @return void 
     */
    public function moveFile($imgPost,$directory)
    {
        move_uploaded_file(
            $imgPost['tmp_name'], 
            $directory . basename($imgPost['name'])
        );
    }

    /**
     * Copy picture in definitive folder
     * 
     * @param string $imgPost   Name of picture post
     * @param string $directory Definitive directory of picture post
     */
    public function renameFile($imgPost, $directory)
    {
        rename(
            $directory . basename($imgPost['name']), 
            $directory . (string)time() . '.' 
            . pathinfo($imgPost['name'])['extension']
        );
    }

    /**
     * Rename picture post with a unique name with time() fonction
     * 
     * @return mixed string if addPost or notPublished
     *               null if preview
     */
    public function managePostImage() 
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession('previewPost') 
            && $var->session('previewPost')->picture() != null
        ) {
            $path = basename($var->session('previewPost')->picture());
                    
            if ($var->issetPost('notPublished') || $var->issetPost('addPost')) {
                $newName = (string)time() . '.' .pathinfo($path)['extension'];

                $this-> verifTmpFolder();

                rename('tmp/'. $path, POST_IMG_DIRECTORY . $newName);
                $var->session('previewPost') -> setPicture(
                    POST_IMG_DIRECTORY . $newName
                );
            }
            return $var->session('previewPost')->picture();            
        } 
        return null;           
    }

    /**
     * Change picture post and delete old picture
     * 
     * @return void
     */
    public function imgChange()
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession('previewPost')) {
            if (file_exists($var->session('previewPost') -> picture())) {
                unlink($var->session('previewPost')-> picture());
            }
            $var->session('previewPost')->setPicture(null);
            $this -> addPostView(
                $form=null, $msg=null, $var->session('previewPost')
            );
        }  
    }
}