<?php

/**
 * Class for manage comment in database
 */

namespace model;

class CommentManager extends Manager
{    
    /**
     * Add a new comment
     * 
     * @param string $nameVisitor  Name of visitor
     * @param string $content      Comment
     * @param bool   $validComment Validation of comment
     * @param int    $user_id      Id of moderator
     * @param int    $post_id      Id of post
     * 
     * @return int Number affected lines
     */
    public function addComment(\model\Comment $comment) {
        $req = $this->db()->prepare(
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

    public function getAllComments($validComment)
    {
        $req = $this->db()->prepare(
            'SELECT id, nameVisitor, content, 
            UNIX_TIMESTAMP(commentDate) AS commentDate,
            validComment,user_id, post_id
            FROM comment
            WHERE  validComment = ?
            ORDER BY commentDate DESC'
        );
        $req -> execute(array($validComment));
        return $req;
    }

    public function getComments($post_id)
    {
        $req = $this->db()->prepare(
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

    public function getComment($id)
    {
        $req = $this->db()->prepare(
            'SELECT id, nameVisitor, content, 
            UNIX_TIMESTAMP(commentDate) AS commentDate,
            emailVisitor, validComment, user_id, post_id
            FROM comment
            WHERE id = ?'
        );
        $req -> execute(array($id));
        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteComment($id)
    {
        $req = $this->db()->prepare(
            'DELETE FROM comment WHERE id = ?'
        );
        $req -> execute(array($id));
        return $req->rowCount();
    }

    public function deletePostComments($post_id)
    {
        $req = $this->db()->prepare(
            'DELETE FROM comment WHERE post_id = ?'
        );
        $req ->execute(array($post_id));
        return $req->rowCount();
    }

    public function updateComment($id)
    {
        $req = $this->db()->prepare(
            'UPDATE comment 
             SET validComment = \'TRUE\' 
             WHERE id = ?'
        );
        $req -> execute(array($id));
        return $req->rowCount();
    }

    public function nbrComments($post_id, $validComment)
    {
        $req = $this->db()->prepare(
            'SELECT COUNT(*) FROM comment 
             WHERE post_id = ? AND validComment = ? '
        );
        $req -> execute(array($post_id, $validComment));
        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    public function nbrAllComments($validComment)
    {
        $req = $this->db()->prepare(
            'SELECT COUNT(*) FROM comment 
             WHERE validComment = ? '
        );
        $req -> execute(array($validComment));
        $nbr = $req->fetch(\PDO::FETCH_ASSOC);
        return $nbr['COUNT(*)'];
    }

    public function lastDateComment()
    {
        $req = $this->db()->query(
            'SELECT MAX(commentDate) FROM comment'
        );
        $lastDateComment = $req->fetch();
        return $lastDateComment['MAX(commentDate)'];
    }
}