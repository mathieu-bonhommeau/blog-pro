<?php

/**
 * Class Manager parent
 */

namespace model;

class Manager 
{ 
    private $_db;

    /**
     * Database connexion 
     * return PDO object
     */
    public function __construct()
    {
        $db = new \PDO(
            'mysql:host=localhost;port=3308;dbname=blog_pro;charset=utf8',
            'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
        $this->setDb($db);
    }

    /**
     * Getters
     */
    public function db()
    {
        return $this->_db;
    }

    /**
     * Setters
     */
    private function setDb($db)
    {
        $this->_db = $db;
    }
}