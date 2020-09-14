<?php

/**
 * This file contains Manager class
 */
namespace model;

/**
 * Class Manager for database connexion
 */
class Manager 
{ 
    private $_database;

    /**
     * Database connexion
     *  
     * @return PDO object
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
     * 
     * @return PDO object
     */
    public function database()
    {
        return $this->_database;
    }

    /**
     * Setters
     * 
     * @param PDO $database PDO object
     * 
     * @return void
     */
    private function setDatabase($database)
    {
        $this->_database = $database;
    }
}