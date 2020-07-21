<?php

class Post 
{ 
    private $_id;
    private $_title;
    private $_chapo;
    private $_content;
    private $_lastDateModif;
    
    /**
     * Getters
     */

    public function id()
    {
        return $this->_id;
    }

    public function title()
    {
        return $this->_title;
    }

    public function chapo()
    {
        return $this->_chapo;
    }

    public function content()
    {
        return $this->_content;
    }

    public function lastDateModif()
    {
        return $this->_lastDateModif;
    }

    /**
     * Setters
     */

    public function setId($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setTitle($title)
    {
        $title = (string)$title;
        $this->_title = $title;
    }

    public function setChapo($chapo)
    {
        $chapo = (string)$chapo;
        $this->_chapo = $chapo;
    }

    public function setContent($content)
    {
        $content = (string)$content;
        $this->_content = $content;
    }

    public function setLastDateModify($lastDateModify)
    {
        $lastDateModify = (int)$lastDateModify;
        $this->_lastDateModify = $lastDateModify;
    }


}