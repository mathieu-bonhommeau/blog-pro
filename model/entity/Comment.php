<?php

namespace model;

class Comment 
{
    private $_id;
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
     * Getter id
     *
     * @return int
     */
    public function id()
    {
         return $this->_id;
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
    public function comment()
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

    public function user_id()
    {
        return $this->_user_id;
    }

    public function post_id()
    {
        return $this->_post_id;
    }
    
    /**
     * Setter setId
     *
     * @param int $id Id of comment
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
     * @param string $comment Comment
     * 
     * @return void
     */
    public function setComment($content)
    {
        $content = (string)$content;
        if (strlen($content) <= 1000) {
            $this->_content = $content;
        } else {
            throw new Exception('MSG_TOO_LONG');
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

    public function setEmailVisitor($emailVisitor)
    {
        $emailControl = preg_match(
            '#^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]{2,}\.[a-z]{2,4}$#',
            $emailVisitor
        );

        if ($emailControl) {
            $this->_emailVisitor = $emailVisitor;
        } else {
            throw new Exception(INVALID_EMAIL);
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
        if ($validComment == 'TRUE' || $validComment =='FALSE') {
            $this->_validComment = $validComment;
        }
    }

    public function setUser_id($user_id)
    {
        $user_id = (int)$user_id;
        $this->_user_id = $user_id;
    }

    public function setPost_id($post_id)
    {
        $post_id = (int)$post_id;
        $this->_post_id = $post_id;
    }
}