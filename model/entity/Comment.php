<?php

class Comment 
{
    private $_id;
    private $_nameVisitor;
    private $_comment;
    private $_commentDate;
    private $_validComment;
    
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
        return $this->_comment;
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
     * Getter validComment
     *
     * @return bool
     */
    public function validComment()
    {
        return $this->_validComment;
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
    public function setComment($comment)
    {
        $comment = (string)$comment;
        $this->_comment = $comment;
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
}