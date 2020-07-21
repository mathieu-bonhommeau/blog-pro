<?php

class Comment 
{
    private $_id;
    private $_nameVisitor;
    private $_comment;
    private $_commentDate;
    private $_validation;

    /**
     * Getters
     */

    public function id()
    {
         return $this->_id;
    }

    public function nameVisitor()
    {
         return $this->_nameVisitor;
    }

    public function comment()
    {
        return $this->_comment;
    }

    public function commentDate()
    {
        return $this->_commentDate;
    }

    public function validation()
    {
        return $this->_validation;
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

    public function setNameVisitor($nameVisitor)
    {
        $nameVisitor = (string)$nameVisitor;
        $this->_nameVisitor = $nameVisitor;
    }

    public function setComment($comment)
    {
        $comment = (string)$comment;
        $this->_comment = $comment;
    }

    public function setCommentDate($commentDate)
    {
        $commentDate = (string)$commentDate;
        $this->_commentDate = $commentDate;
    }

    public function setValidation($validation)
    {
        if ($validation === 0) {
            $this->_validation = 'FALSE';
        } elseif ($validation === 1) {
            $this->_validation = 'TRUE';
        }
    }
}