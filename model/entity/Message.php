<?php

/**
 * This file contains Message class
 */
namespace model;

/**
 * Class for mail Messages.
 * 
 * PHP version 7.3.12
 * 
 * @category  Entity
 * @package   \model\entity
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Message extends Entity
{
    private $_name;
    private $_firstName;
    private $_email;
    private $_message;

    /**
     * Getter $_inputName
     * 
     * @return string
     */
    public function inputName()
    {
        return $this->_name;
    }

    /**
     * Getter $_inputFirstName
     * 
     * @return string
     */
    public function inputFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Getter $_inputEmail
     * 
     * @return string Email format
     */
    public function inputEmail()
    {
        return $this->_email;
    }

    /**
     * Getter $_inputEmail
     * 
     * @return string
     */
    public function inputMessage()
    {
        return $this->_message;
    }

    /**
     * Setter $_inputName
     * 
     * @param $name Name of visitor
     * 
     * @return void
     */
    public function setInputName($name)
    {
        $name = (string)$name;
        $this->_name = $name;
    }

    /**
     * Setter $_inputFirstName
     * 
     * @param $firstName First name of visitor
     * 
     * @return void
     */
    public function setInputFirstName($firstName)
    {
        $firstName = (string)$firstName;
        $this->_firstName = $firstName;
    }

    /**
     * Setter $_inputEmail
     * 
     * @param $email Format control with regex
     * 
     * @return void
     */
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
    
    /**
     * Setter $_inputMessage
     * 
     * @param $message Message of visitor
     * 
     * @return void
     */
    public function setInputMessage($message)
    {
        $message = (string)$message;
        $this->_message = $message;
    }
        
    /**
     * Method for send email
     * Email display in message change with $inputEmail
     * 
     * @param $email Email of visitor
     * 
     * @return bool
     */
    public function sendMessage($email)
    {
        $var = new \config\GlobalVar;

        $header="MIME-Version: 1.0\r\n";
        $header.= HEADER_MAIL."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $toEmail = $email;
        $subject = 'De ' . $this->inputFirstName() . ' ' . $this->inputName();

        if ($var->issetGet('delete')) {
            $inputEmail = '<br />' . 'mail : ' . SUPPORT_EMAIL;
        } else {
            $inputEmail = '<br />' . 'mail : ' . $this->inputEmail();
        }

        $message = $this->inputMessage() . $inputEmail;

        $mail = mail($toEmail, $subject, $message, $header);
        return $mail;
        
    } 
}