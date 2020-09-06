<?php

/**
 * Class for post entities
 */

namespace model;

class Post
{ 
    private $_postId;
    private $_title;
    private $_chapo;
    private $_content;
    private $_lastDateModif;
    private $_picture;
    private $_published;
    private $_authorName;
        
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
    public function postId()
    {
        return $this->_postId;
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

    public function picture()
    {
        return $this->_picture;
    }

    public function published() 
    {
        return $this->_published;
    }
    
    /**
     * Getter $_userName / Author of post
     *
     * @return int
     */
    public function authorName()
    {
        return $this->_authorName;
    }
    
    /**
     * Setter setId
     *
     * @param int $id Id of post
     * 
     * @return void
     */
    public function setPostId($postId)
    {
        $postId = (int)$postId;
        if ($postId > 0) {
            $this->_postId = $postId;
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

    public function setPicture($picture)
    { 
        if ($picture == null ) {
            $this->_picture = null;
        } else {
            $picture = (string)$picture;
            $this->_picture = $picture;
        }
    }

    public function setPublished($published)
    {
        if (in_array($published, ['TRUE', 'FALSE'])) {    
            $this->_published = $published;
        } else {
            $this->_published = 'FALSE';
        }
    }

    public function setAuthorName($authorName)
    {
        $authorName = (string)$authorName;
        $this->_authorName = $authorName;
    }


}