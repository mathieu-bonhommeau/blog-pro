<?php

/**
 * Class Manager parent
 */

namespace model;

class Manager 
{ 
    private $_database;

    /**
     * Database connexion 
     * return PDO object
     */
    public function __construct()
    {
        $connect = HOST . ';' . PORT . ';' . DBNAME . ';' . CHARSET . ';';
        $database = new \PDO(
            $connect, USER, PASSWORD, 
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION) 
        );
        $this->setDatabase($database);
    }

    /**
     * Getters
     */
    public function database()
    {
        return $this->_database;
    }

    /**
     * Setters
     */
    private function setDatabase($database)
    {
        $this->_database = $database;
    }
}