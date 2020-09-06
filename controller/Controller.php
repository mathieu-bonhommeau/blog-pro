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
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        } else {
            $this->user = null;
        }
    }

    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment($loader, ['cache' => false, 'debug' => true]); //'/tmp' 
    }

    public function sendMessage(array $form, $email)
    {
        if (!isset($_SESSION['user'])) {
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
        if (isset($_SESSION[$name])) {
            return true;
        }
        return false;
    }
}