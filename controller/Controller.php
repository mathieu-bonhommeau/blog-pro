<?php

/**
 * This file contains Controller class
 */
namespace controller;

/**
 * Class for init Twig, send email and control session
 * 
 * PHP version 7.3.12
 * 
 * @category  Controller
 * @package   \controller
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Controller
{
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
    public function error($exception)
    {
        $view = new \view\View;

        $data = array('exception' => $exception);
        $page = 'errorView.twig';
        $view -> displayPage($data, $page);
    }
}