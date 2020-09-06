<?php

namespace model;

class Message 
{
    private $_name;
    private $_firstName;
    private $_email;
    private $_message;

    public function __construct(array $form)
    {
        foreach ($form as $key => $value) {
            $key = ucfirst($key);
            $method = 'set'. $key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //Getters
    public function inputName()
    {
        return $this->_name;
    }

    public function inputFirstName()
    {
        return $this->_firstName;
    }

    public function inputEmail()
    {
        return $this->_email;
    }

    public function inputMessage()
    {
        return $this->_message;
    }

    //Setters
    public function setInputName($name)
    {
        $name = (string)$name;
        $this->_name = $name;
    }

    public function setInputFirstName($firstName)
    {
        $firstName = (string)$firstName;
        $this->_firstName = $firstName;
    }

    public function setInputEmail($email)
    {
        $emailControl = preg_match(
            '#^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]{2,}\.[a-z]{2,4}$#',
            $email
        );

        if ($emailControl) {
            $this->_email = $email;
            return;
        } 
            
        throw new\Exception(INVALID_EMAIL);
    
    }
    
    public function setInputMessage($message)
    {
        $message = (string)$message;
        $this->_message = $message;
    }

    public function sendMessage($email)
    {
        $header="MIME-Version: 1.0\r\n";
        $header.= HEADER_MAIL."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $toEmail = $email;
        $subject = 'De ' . $this->inputFirstName() . ' ' . $this->inputName();

        if (isset($_GET['delete'])) {
            $inputEmail = '<br />' . 'mail : ' . SUPPORT_EMAIL;
        } else {
            $inputEmail = '<br />' . 'mail : ' . $this->inputEmail();
        }

        $message = $this->inputMessage() . $inputEmail;

        $mail = mail($toEmail, $subject, $message, $header);
        return $mail;
        
    } 
}