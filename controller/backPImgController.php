<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackPImgController extends BackPostController
{
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

    public function moveFile($imgPost,$directory)
    {
        move_uploaded_file(
            $imgPost['tmp_name'], 
            $directory . basename($imgPost['name'])
        );
    }

    public function renameFile($imgPost, $directory)
    {
        rename(
            $directory . basename($imgPost['name']), 
            $directory . (string)time() . '.' 
            . pathinfo($imgPost['name'])['extension']
        );
    }

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