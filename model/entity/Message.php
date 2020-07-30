<?php

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
        } else {
            throw new Exception('Oups !!! L\'email saisi est invalide');
        }
    }
    
    public function setInputMessage($message)
    {
        $message = (string)$message;
        $this->_message = $message;
    }

    public function sendMessage()
    {
        mail(
            EMAIL, SUBJECT_EMAIL, $this->inputMessage(), 
            array(
                  $this->inputName(), 
                  $this->inputFirstName(), 
                  $this->inputEmail()
                )
        );
    }
}