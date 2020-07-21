<?php

class Manager 
{ 
    private $_db;

    public function __construct()
    {
        try
        {
            $db = new PDO(
                'mysql:host=localhost;port=3308;dbname=blog_pro;charset=utf8',
                'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            $this->setDb($db);
            echo 'la connexion fonctionne';

        }
        catch(Exception $e)
        {
            echo $e -> getMessage();
        }
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