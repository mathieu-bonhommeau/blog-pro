<?php

/**
 * This file contains CommentManager class
 */
namespace model;

/**
 * Class for manage Comments in database
 */
class CommentManager extends Manager
{    
    /**
     * Add a new comment
     * 
     * @param string $comment Comment Object
     * 
     * @return int Number affected lines
     */
    public function addComment(\model\Comment $comment) {
        $req = $this->database()->prepare(
            'INSERT INTO comment (
            nameVisitor, content, commentDate, 
            emailVisitor, validComment, user_id, post_id
            )
            VALUE (
            :nameVisitor, :content, NOW(), 
            :emailVisitor, :validComment, :user_id, :post_id
            )'
        );
        $req -> execute(
            array('nameVisitor' => $comment->nameVisitor(),
                  'content' => $comment->content(),
                  'emailVisitor' => $comment->emailVisitor(),
                  'validComment' => $comment->validComment(),
                  'user_id' => $comment->user_id(),
                  'post_id' => $comment->post_id()
            )
        );
        return $req->rowCount();
    }

    /**
     * Get comments valid or no valid and sort the result by $try
     * 
     * @param bool   $validComment If param no exist -> null 
     * @param string $try          If param no exist -> null
     * 
     * @return PDO result Result of request need a fetch process
     */
    public function getAllComments($validComment=null, $try=null)
    {
        if ($validComment == null) {
            $inputReq = null;
        } else {
            $inputReq = 'WHERE validComment = "' . $validComment . '"';
        }

        if ($try == null || ($try != 'post_id' && $try != 'nameVisitor')) {
            $try = 'commentDate';
        }

        $req = $this->database()->query(
            'SELECT id, nameVisitor, content, emailVisitor, 
            UNIX_TIMESTAMP(commentDate) AS commentDate,
            validComment,user_id, post_id
            FROM comment ' . $inputReq . 
            ' ORDER BY ' . $try . ' DESC'
        );
        return $req;
    }

    /**
     * Get comments linked to a post and order by comment Date
     * 
     * @param int $post_id Id of post
     * 
     * @return PDO result Result of request need a fetch process
     */
    public function getComments($post_id)
    {
        $req = $this->database()->prepare(
            'SELECT id, nameVisitor, content, 
            UNIX_TIMESTAMP(commentDate) AS commentDate,
            validComment,user_id, post_id
            FROM comment 
            WHERE post_id = ? AND validComment = \'TRUE\'
            ORDER BY commentDate DESC'
        );
        $req -> execute(array($post_id));
        return $req;
    }

    /**
     * Get a comment
     * 
     * @param int $commentId Id of comment
     * 
     * @return array
     */
    public function getComment($commentId)
    {
        $req = $this->database()->prepare(
            'SELECT id, nameVisitor, content, 
            UNIX_TIMESTAMP(commentDate) AS commentDate,
            emailVisitor, validComment, user_id, post_id
            FROM comment
            WHERE id = ?'
        );
        $req -> execute(array($commentId));
        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Delete a comment
     * 
     * @param int $commentId Id of comment
     * 
     * @return int Number of affected lines
     */
    public function deleteComment($commentId)
    {
        $req = $this->database()->prepare(
            'DELETE FROM comment WHERE id = ?'
        );
        $req -> execute(array($commentId));
        return $req->rowCount();
    }

    public function deletePostComments($post_id)
    {
        $req = $this->database()->prepare(
            'DELETE FROM comment WHERE post_id = ?'
        );
        $req ->execute(array($post_id));
        return $req->rowCount();
    }

    /**
     * Update a comment
     * 
     * @param int $commentId Id of comment
     * 
     * @return int Number of affected lines
     */
    public function updateComment($commentId)
    {
        $req = $this->database()->prepare(
            'UPDATE comment 
             SET validComment = \'TRUE\' 
             WHERE id = ?'
        );
        $req -> execute(array($commentId));
        return $req->rowCount();
    }

    /**
     * Count the number of comments by post and valid or no valid
     * 
     * @param int  $post_id      Post id of comment
     * @param bool $validComment Comment is valid or no
     * 
     * @return array
     */
    public function nbrComments($post_id, $validComment)
    {
        $req = $this->database()->prepare(
            'SELECT COUNT(*) FROM comment 
             WHERE post_id = ? AND validComment = ? '
        );
        $req -> execute(array($post_id, $validComment));
        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Count the number of all comments valid or no valid
     * 
     * @param bool $validComment Comment is valid or no
     * 
     * @return int
     */
    public function nbrAllComments($validComment)
    {
        $req = $this->database()->prepare(
            'SELECT COUNT(*) FROM comment 
             WHERE validComment = ? '
        );
        $req -> execute(array($validComment));
        $nbr = $req->fetch(\PDO::FETCH_ASSOC);
        return $nbr['COUNT(*)'];
    }

    /**
     * Get the date of the last comment
     * 
     * @return string Date format Datetime
     */
    public function lastDateComment()
    {
        $req = $this->database()->query(
            'SELECT MAX(commentDate) FROM comment'
        );
        $lastDateComment = $req->fetch();
        return $lastDateComment['MAX(commentDate)'];
    }
}