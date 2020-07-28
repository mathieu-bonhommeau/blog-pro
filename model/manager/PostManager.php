<?php

/**
 * Class for manage post in database
 */
class PostManager extends Manager
{
    /**
     * Recovers all the posts
     * 
     * @param int $number Number of posts
     * 
     * @return array Result of request need a fetch process
     */
    public function getPosts($number)
    {
        $number = (int)$number;
        $req = $this->db()->query(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id
            ORDER BY lastDateModif DESC LIMIT ' . $number
        );
        return $req;
    }

    /**
     * Recovers one post with the id post
     * 
     * @param int $id Id post in database
     * 
     * @return array Result of request
     */
    public function getPost($id)
    {
        $req = $this->db()->prepare(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id
            WHERE post.id = ?'
        );
        $req->execute(array($id));
        return $data = $req->fetch(PDO::FETCH_ASSOC);
    }

    
    /**
     * Add new post 
     *
     * @param string $title   Title of post
     * @param string $chapo   Chapo of post
     * @param string $content Content of post
     * @param int    $user_id Author id of post
     * 
     * @return int Number of affected lines
     */
    public function addPost($title, $chapo, $content, $user_id)
    {
        $req = $this->db()->prepare(
            'INSERT INTO post (title, chapo, content, lastDateModif, user_id) 
            VALUES (:title, :chapo, :content, NOW(), :user_id)'
        );
        $req->execute(
            array(
                'title' => $title, 
                'chapo' => $chapo,
                'content' => $content,
                'user_id' => $user_id
                )
        );
        return $req->rowCount();
    }

        
    /**
     * Update a post
     *
     * @param int    $id      Id of post
     * @param string $title   Title of post
     * @param string $chapo   Chapo of post
     * @param string $content Content of post
     * 
     * @return int Number of affected lines
     */
    public function updatePost($id, $title, $chapo, $content)
    {
        $req = $this->db()->prepare(
            'UPDATE post SET title = :title, chapo = :chapo, 
            content = :content, lastDateModif = NOW() 
            WHERE id = :id'
        );
        $req->execute(
            array(
                'title' => $title,
                'chapo' => $chapo,
                'content' => $content,
                'id' => $id
            )
        );
        return $req->rowCount();
    }
    
    /**
     * Delete a post
     *
     * @param mixed $id Id of post
     * 
     * @return int Number of affected lines
     */
    public function deletePost($id)
    {
        $req = $this->db()->prepare(
            'DELETE FROM post WHERE id = ?'
        );
        $req->execute(array($id));
        return $req->rowCount();
    }

}