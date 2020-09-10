<?php

namespace controller;
use Twig;

class Controller
{
    protected $twig;
    protected $user;
    protected $msg;

    public function msg()
    {
        return $this->msg;
    }

    public function __construct()
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession('user')) {
            $this->user = $var->session('user');
        } else {
            $this->user = null;
        }
    }

    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment(
            $loader, ['cache' => false, 'debug' => true]
        ); 
    }

    public function sendMessage(array $form, $email)
    {
        $var = new \config\GlobalVar;

        if (!$var->issetSession('user')) {
            foreach ($form as $key => $value) {
                $form[$key] = htmlspecialchars($form[$key]);
            }
        }
        $message = new \model\Message($form);
        $mail = $message -> sendMessage($email);

        if ($mail) {
            $msg = MSG_OK;
        } else {
            $msg = MSG_NO_OK;
        }
        $this->msg = $msg;
    }

    public function sessionControl($name)
    {
        $var = new \config\GlobalVar;
        
        if ($var->issetSession($name)) {
            return true;
        }
        return false;
    }
}