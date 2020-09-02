<?php

namespace model;

class User 
{ 
    private $_id;
    private $_userName;
    private $_password;
    private $_userEmail;
    private $_profilPicture;
    private $_authorName;
    private $_registerDate;
    private $_type;

    private static $_role = array('administrator', 'author', 'moderator');

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }

        }
    }

    public function id()
    {
        return $this->_id;
    }

    public function userName()
    {
        return $this->_userName;
    }

    public function password()
    {
        return $this->_password;
    }

    public function userEmail()
    {
        return $this->_userEmail;
    }

    public function profilPicture()
    {
        return $this->_profilPicture;
    }

    public function authorName()
    {
        return $this->_authorName;
    }

    public function registerDate()
    {
        return $this->_registerDate;
    }

    public function type()
    {
        return $this->_type;
    }

    public function setId($id)
    {
        $id = (int)$id;
        $this->_id = $id;
    }

    public function setUserName($userName)
    {
        $userName = (string)$userName;
        $this->_userName = $userName;
    }

    public function setPassword($password)
    {
        $password = (string)$password; 
        $this->_password = $password;
    }

    public function setUserEmail($userEmail)
    {
        if ($userEmail == null) {
            $this->_userEmail = null;

        } else {
            $emailControl = preg_match(
                '#^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]{2,}\.[a-z]{2,4}$#',
                $userEmail
            );
    
            if ($emailControl) {
                $this->_userEmail = $userEmail;
            } else {
                throw new \Exception(INVALID_EMAIL);
            }
        }
        
    }

    public function setProfilPicture($profilPicture) 
    {
        if ($profilPicture == null ) {
            $this->_profilPicture = null;
        } else {
            $picture = (string)$profilPicture;
            $this->_profilPicture = $profilPicture;
        }
    }

    public function setAuthorName($authorName)
    {
        $authorName = (string)$authorName;
        $this->_authorName = $authorName;
    }

    public function setRegisterDate($registerDate)
    {
        $registerDate = (int)$registerDate;
        $this->_registerDate = $registerDate;
    }

    public function setType($type)
    {
        if (in_array($type, self::$_role)) {
            $this->_type = $type;
        }
    }
}