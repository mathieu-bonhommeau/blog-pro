<?php

/**
 * Class for post entities
 */
class Post
{ 
    private $_id;
    private $_title;
    private $_chapo;
    private $_content;
    private $_lastDateModif;
        
    /**
     * __construct Init object 
     *
     * @param array $data Array with database data
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this -> hydrate($data);
    }
    
    /**
     * Hydrate 
     *
     * @param array $data Array with database data
     * 
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key); 
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Getter $_id
     * 
     * @return int
     */
    public function id()
    {
        return $this->_id;
    }
    
    /**
     * Getter $_title
     *
     * @return string
     */
    public function title()
    {
        return $this->_title;
    }

    /**
     * Getter $_chapo
     *
     * @return string
     */
    public function chapo()
    {
        return $this->_chapo;
    }

        
    /**
     * Getter $_content
     *
     * @return string
     */
    public function content()
    {
        return $this->_content;
    }
    
    /**
     * Getter $_lastDateModif
     *
     * @return int
     */
    public function lastDateModif()
    {
        return $this->_lastDateModif;
    }
    
    /**
     * Setter setId
     *
     * @param int $id Id of post
     * 
     * @return void
     */
    public function setId($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }
    
    /**
     * Setter setTitle
     *
     * @param string $title Title of post
     * 
     * @return void
     */
    public function setTitle($title)
    {
        $title = (string)$title;
        $this->_title = $title;
    }
    
    /**
     * Setter setChapo
     *
     * @param string $chapo Chapo of post
     * 
     * @return void
     */
    public function setChapo($chapo)
    {
        $chapo = (string)$chapo;
        $this->_chapo = $chapo;
    }
    
    /**
     * Setter setContent
     *
     * @param string $content Content of post
     * 
     * @return void
     */
    public function setContent($content)
    {
        $content = (string)$content;
        $this->_content = $content;
    }
    
    /**
     * Setter setLastDateModif
     *
     * @param int $lastDateModif Timestamp of The last Modification 
     * 
     * @return void
     */
    public function setLastDateModif($lastDateModif)
    {
        $lastDateModif = (int)$lastDateModif;
        $this->_lastDateModif = $lastDateModif;
    }


}