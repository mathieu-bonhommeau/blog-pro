<?php

/**
 * This file contains Comment class
 */
namespace model;

/**
 * Class for post comments.
 * 
 * PHP version 7.3.12
 * 
 * @category  Entity
 * @package   \model\entity
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class Comment
{
    private $_commentId;
    private $_nameVisitor;
    private $_content;
    private $_commentDate;
    private $_emailVisitor;
    private $_validComment;
    private $_user_id;
    private $_post_id;
    
    /**
     * __construct Init object
     *
     * @param array $data Array Array with database data
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
     * @param array $data Array Array with database data
     * 
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $key = ucfirst($key);
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this -> $method($value);
            }
        }
    }
    
    /**
     * Getter commentId
     *
     * @return int
     */
    public function commentId()
    {
         return $this->_commentId;
    }
    
    /**
     * Getter nameVisitor
     *
     * @return string
     */
    public function nameVisitor()
    {
         return $this->_nameVisitor;
    }
    
    /**
     * Getter comment
     *
     * @return string
     */
    public function content()
    {
        return $this->_content;
    }
    
    /**
     * Getter commentDate
     *
     * @return int
     */
    public function commentDate()
    {
        return $this->_commentDate;
    }

    /**
     * Getter emailVisitor
     * 
     * @return string email format
     */
    public function emailVisitor()
    {
        return $this->_emailVisitor;
    }
    
    /**
     * Getter validComment
     *
     * @return bool
     */
    public function validComment()
    {
        return $this->_validComment;
    }

    /**
     * Getter user_id
     * 
     * @return int
     */
    public function user_id()
    {
        return $this->_user_id;
    }

    /**
     * Getter post_id
     * 
     * @return int
     */
    public function post_id()
    {
        return $this->_post_id;
    }
    
    /**
     * Setter setId
     *
     * @param int $commentId Id of comment
     * 
     * @return void
     */
    public function setId($commentId)
    {
        $commentId = (int)$commentId;
        if ($commentId > 0) {
            $this->_commentId = $commentId;
        }
    }
    
    /**
     * Setter setNameVisitor
     *
     * @param string $nameVisitor Name of visitor who post comment
     * 
     * @return void
     */
    public function setNameVisitor($nameVisitor)
    {
        $nameVisitor = (string)$nameVisitor;
        $this->_nameVisitor = $nameVisitor;
    }
    
    /**
     * Setter setComment
     *
     * @param string $content Content of comment 
     * 
     * @return void
     */
    public function setContent($content)
    {
        $content = (string)$content;
        if (strlen($content) <= 700) {
            $this->_content = $content;
        } else {
            throw new \Exception(MSG_TOO_LONG);
        }  
    }
    
    /**
     * Setter setCommentDate
     *
     * @param int $commentDate Timestamp of comment
     * 
     * @return void
     */
    public function setCommentDate($commentDate)
    {
        $commentDate = (string)$commentDate;
        $this->_commentDate = $commentDate;
    }

    /**
     * Setter emailVisitor
     * 
     * @param $emailVisitor Email of visitor
     * 
     * @return void
     */
    public function setEmailVisitor($emailVisitor)
    {
        $emailControl = preg_match(
            '#^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]{2,}\.[a-z]{2,4}$#',
            $emailVisitor
        );

        if ($emailControl) {
            $this->_emailVisitor = $emailVisitor;
            
        } else {
            throw new \Exception(INVALID_EMAIL);
        }
    }
    
    /**
     * Setter setValidComment
     *
     * @param bool $validComment Validation comment
     * 
     * @return void
     */
    public function setValidComment($validComment)
    {
        if (in_array($validComment, ['TRUE', 'FALSE'])) {    
            $this->_validComment = $validComment;
        } else {
            $this->_validComment = 'FALSE';
        }
    }

    /**
     * Setter user_id
     * 
     * @param int $user_id User id
     * 
     * @return void
     */
    public function setUser_id($user_id)
    {
        if (is_null($user_id) || $user_id == 0) {
            $user_id = null;
        } else {
            $user_id = (int)$user_id;
        }
        $this->_user_id = $user_id;
    }

    /**
     * Setter post_id
     * 
     * @param $post_id Post id
     * 
     * @return void
     */
    public function setPost_id($post_id)
    {
        $post_id = (int)$post_id;
        $this->_post_id = $post_id;
    }
}