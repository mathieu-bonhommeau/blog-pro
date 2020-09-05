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
        $connect = HOST . ';' . PORT . ';' . DBNAME . ';' . CHARSET . ';';
        $db = new \PDO(
            $connect, USER, PASSWORD, 
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION) 
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