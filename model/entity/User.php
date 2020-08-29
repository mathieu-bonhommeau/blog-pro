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
    private $_type;

    private static $_role = array('Administrateur', 'Auteur', 'Moderateur');

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

    public function setprofilPicture($profilPicture) 
    {
        if (preg_match(
            "#^public/images/profilPicture/[a-zA-Z0-9]+\.png$#", $profilPicture
        )) {
            $this->_profilPicture = $profilPicture;
        }
    }

    public function setAuthorName($authorName)
    {
        $authorName = (string)$authorName;
        $this->_authorName = $authorName;
    }

    public function setType($type)
    {
        if (in_array($type, self::$_role)) {
            $this->_type = $type;
        }
    }
}