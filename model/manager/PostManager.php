<?php

/**
 * Class for manage post in database
 */

namespace model;

class PostManager extends Manager
{
    /**
     * Recovers all the posts
     * 
     * @param int $number Number of posts
     * 
     * @return array Result of request need a fetch process
     */
    public function getPosts()
    {
        $req = $this->db()->query(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            picture, published, user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id 
            ORDER BY lastDateModif DESC'
        );
        return $req;
    }

    public function getHomePosts($limit)
    {
        $req = $this->db()->query(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            picture, published, user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id 
            WHERE post.published = \'TRUE\'
            ORDER BY lastDateModif DESC LIMIT ' . $limit
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
            picture, published, user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id
            WHERE post.id = ?'
        );
        $req->execute(array($id));
        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return $data;   
    }

    public function getUserPosts($user_Id)
    {
        $req = $this->db()->prepare(
            'SELECT post.id, post.title, user.authorName,
             UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
             published
             FROM post
             INNER JOIN user ON post.user_id = user.id
             WHERE post.user_id = ?'
        );
        $req -> execute(array($user_Id));
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = $data;
        }

        if (isset($posts)) {
            return $posts;
        } else {
            return null;
        }
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
    public function addPost(Post $newPost)
    {
        $req = $this->db()->prepare(
            'INSERT INTO post (title, chapo, content, lastDateModif, picture, published, user_id) 
            VALUES (:title, :chapo, :content, NOW(), :picture, :published, :user_id)'
        );
        $req->execute(
            array(
                'title' => $newPost->title(), 
                'chapo' => $newPost->chapo(),
                'content' => $newPost->content(),
                'picture' => basename($newPost->picture()),
                'published' => $newPost->published(),
                'user_id' => $_SESSION['user']->id()
                )
        );
        return array($req->rowCount(),$this->db()->lastInsertId());
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
    public function updatePost(Post $post)
    {
        $req = $this->db()->prepare(
            'UPDATE post SET title = :title, chapo = :chapo, 
            content = :content, lastDateModif = NOW(), picture = :picture,
            published = :published 
            WHERE id = :id'
        );
        $req->execute(
            array(
                'title' => $post ->title(),
                'chapo' => $post->chapo(),
                'content' => $post->content(),
                'picture' => basename($post->picture()),
                'published' => $post->published(),
                'id' => $post ->id()
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

    public function countPosts()
    {
        $req = $this->db()->query('SELECT COUNT(*) FROM post');
        $countPosts = $req->fetch();
        return $countPosts['COUNT(*)'];
    }

    public function countUserPosts($user_id)
    {
        $req = $this->db()->prepare(
            'SELECT COUNT(*) 
             FROM post
             WHERE user_id = ?'
        );
        $req -> execute(array($user_id));
        $countPosts = $req->fetch();
        return $countPosts['COUNT(*)'];
    }

    public function lastDatePost()
    {
        $req = $this->db()->query(
            'SELECT MAX(lastDateModif) FROM post
             WHERE published = \'TRUE\''
        );
        $lastDateModif = $req->fetch();
        return $lastDateModif['MAX(lastDateModif)'];
    }

    public function lastDateUserPost($user_id)
    {
        $req = $this->db()->prepare(
            'SELECT MAX(lastDateModif) FROM post
             WHERE published = \'TRUE\'
             AND user_id = ?'
        );
        $req -> execute(array($user_id));
        $lastDateModif = $req->fetch();
        return $lastDateModif['MAX(lastDateModif)'];
    }

    public function getPostImg($picture)
    {
        $req = $this->db()->prepare('SELECT COUNT(*) FROM post WHERE picture = ?');
        $req -> execute(array($picture));
        $result = $req -> fetch();
        return $result['COUNT(*)'];
    }

}