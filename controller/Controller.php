<?php

/**
 * This file contains Controller class
 */
namespace controller;
use Twig;
use Twig_Extensions_Extension_Text;

/**
 * Class for init Twig, send email and control session
 */
class Controller
{
    protected $twig;
    protected $user;
    protected $msg;

    /**
     * Getter $msg
     * 
     * @return string
     */
    public function msg()
    {
        return $this->msg;
    }

    /**
     * __construct Init object
     * 
     * @return void
     */
    public function __construct()
    {
        $var = new \config\GlobalVar;

        if ($var->issetSession('user')) {
            $this->user = $var->session('user');
        } else {
            $this->user = null;
        }
    }

    /**
     * Init twig
     * 
     * @return void
     */
    public function twigInit()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $this->twig = new Twig\Environment(
            $loader, ['cache' => false, 'debug' => true]
        ); 
    }

    /**
     * Method for send emails
     * 
     * @param array  $form  Input data in form
     * @param string $email Email format destination email
     * 
     * @return void
     */
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

    /**
     * Control session
     * 
     * @param string $name Index of session
     * 
     * @return bool
     */
    public function sessionControl($name)
    {
        $var = new \config\GlobalVar;
        
        if ($var->issetSession($name)) {
            return true;
        }
        return false;
    }

    /**
     * Display error page
     * 
     * @param string $exception Error message define in config.php
     * 
     * @return void
     */
    public function errorView($exception)
    {
        $this->twigInit();
        $this->twig->addExtension(new Twig\Extension\DebugExtension); //think to delete this line
        $this->twig->addExtension(new Twig_Extensions_Extension_Text()); 

        echo $this->twig->render(
            'errorView.twig', array(
                'exception' => $exception 
            )
        );
    }
}