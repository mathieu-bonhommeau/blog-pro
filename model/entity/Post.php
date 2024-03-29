<?php

/**
 * This file contains Post class
 */

namespace model;

/**
 * Class for Posts.
 * 
 * PHP version 7.3.12
 * 
 * @category  Entity
 * @package   \model\entity
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Post extends Entity
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
     * Getter $_postId
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

    /**
     * Getter $_picture
     * 
     * @return string
     */
    public function picture()
    {
        return $this->_picture;
    }

    /**
     * Getter $_published
     * 
     * @return bool
     */
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
     * Setter $_postId
     *
     * @param int $postId Id of post
     * 
     * @return void
     */
    public function setId($postId)
    {
        $postId = (int)$postId;
        if ($postId > 0) {
            $this->_postId = $postId;
        }
    }
    
    /**
     * Setter $_title
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
     * Setter $_chapo
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
     * Setter $_content
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
     * Setter $_lastDateModif
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

    /**
     * Setter $_picture
     * 
     * @param string $picture Image name of post
     * 
     * @return void
     */
    public function setPicture($picture)
    { 
        if ($picture == null ) {
            $this->_picture = null;
        } else {
            $picture = (string)$picture;
            $this->_picture = $picture;
        }
    }

    /**
     * Setter $_published
     * 
     * @param bool $published
     * 
     * @return void
     */
    public function setPublished($published)
    {
        if (in_array($published, ['TRUE', 'FALSE'])) {    
            $this->_published = $published;
        } else {
            $this->_published = 'FALSE';
        }
    }

    /**
     * Setter $_authorName
     * 
     * @param string $authorName Author full name of post
     */
    public function setAuthorName($authorName)
    {
        $authorName = (string)$authorName;
        $this->_authorName = $authorName;
    }


}