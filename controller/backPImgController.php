<?php

namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

class BackPImgController extends BackPostController
{
    public function uploadFile($imgPost=null)
    {  
        $this -> verifTmpFolder();

        if (!($imgPost['error'] == 0  && $imgPost['size'] <= 2000000)) {
            throw new \Exception(UPLOAD_NO_OK);
        }
        if (!in_array(pathinfo($imgPost['name'])['extension'], AUTHORIZED_EXTENSIONS)
        ) {
            throw new \Exception(UPLOAD_NO_OK);
        }

        if (isset($_POST['addPost']) || isset($_POST['notPublished'])
        ) {
            $this -> moveFile($imgPost, POST_IMG_DIRECTORY);
            $this -> renameFile($imgPost, POST_IMG_DIRECTORY);
            return POST_IMG_DIRECTORY . (string)time() . '.' 
            . pathinfo($imgPost['name'])['extension'];
        } 
        
        if (isset($_POST['preview'])
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
        if (isset($_SESSION['previewPost']) 
            && $_SESSION['previewPost']->picture() != null
        ) {
            $path = basename($_SESSION['previewPost']->picture());
                    
            if (isset($_POST['notPublished']) || isset($_POST['addPost'])) {
                $newName = (string)time() . '.' .pathinfo($path)['extension'];

                $this-> verifTmpFolder();

                rename('tmp/'. $path, POST_IMG_DIRECTORY . $newName);
                $_SESSION['previewPost'] -> setPicture(
                    POST_IMG_DIRECTORY . $newName
                );
            }
            return $_SESSION['previewPost']->picture();            
        } 
        return null;           
    }

    public function imgChange()
    {
        if (isset($_SESSION['previewPost'])) {
            if (file_exists($_SESSION['previewPost'] -> picture())) {
                unlink($_SESSION['previewPost'] -> picture());
            }
            $_SESSION['previewPost']->setPicture(null);
            $this -> addPostView($form=null, $msg=null, $_SESSION['previewPost']);
        }  
    }
}