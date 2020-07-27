<?php

/**
 * Class for manage comment in database
 */
class CommentManager extends Manager
{    
    /**
     * Add a new comment
     * 
     * @param string $nameVisitor  Name of visitor
     * @param string $comment      Comment
     * @param bool   $validComment Validation of comment
     * @param int    $user_id      Id of moderator
     * @param int    $post_id      Id of post
     * 
     * @return int Number affected lines
     */
    public function addComment(
        $nameVisitor, $comment, $validComment, $user_id, $post_id
    ) {
        $req = $this->db()->prepare(
            'INSERT INTO comment (
            nameVisitor, comment, commentDate, validComment, user_id, post_id
            )
            VALUE (
            :nameVisitor, :comment, NOW(), :validComment, :user_id, :post_id
            )'
        );
        $req -> execute(
            array('nameVisitor' => $nameVisitor,
                  'comment' => $comment,
                  'validComment' => $validComment,
                  'user_id' => $user_id,
                  'post_id' => $post_id
            )
        );
        return $req->rowCount();
    }

    public function getComments()
    {
        $req = $this->db()->query(
            'SELECT nameVisitor, comment, UNIX_TIMESTAMP(commentDate) AS commentDate
             validComment, user'
        )
    }*/
}