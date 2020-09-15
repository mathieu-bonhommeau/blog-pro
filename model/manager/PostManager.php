<?php

/**
 * This file contains PostManager class
 */
namespace model;

/**
 * Class for manage Posts in database
 * 
 * PHP version 7.3.12
 * 
 * @category  Manager
 * @package   \model\manager
 * @author    Mathieu Bonhommeau <mat.bonohmmeau85@gmail.com>
 * @copyright 2020 Mathieu Bonhommeau
 * @link      http://localhost/blog-pro/index.php
 */
class PostManager extends Manager
{
    /**
     * Get all posts
     * 
     * @return PDO result sort by date
     * Result of request need a fetch process 
     */
    public function getPosts()
    {
        $req = $this->database()->query(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            picture, published, user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id 
            ORDER BY lastDateModif DESC'
        );
        return $req;
    }

    /**
     * Get posts for homepage
     * 
     * @param int $limit Number of posts display on homepage
     * 
     * @return PDO object sort by date
     * Result of request need a fetch process 
     */
    public function getHomePosts($limit)
    {
        $req = $this->database()->query(
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
     * Get one post with the id post
     * 
     * @param int $postId Id post in database
     * 
     * @return array Result of request
     */
    public function getPost($postId)
    {
        $req = $this->database()->prepare(
            'SELECT post.id, post.title, post.chapo, post.content, 
            UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
            picture, published, user.authorName
            FROM post 
            INNER JOIN user ON user.id = post.user_id
            WHERE post.id = ?'
        );
        $req->execute(array($postId));
        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return $data;   
    }

    /**
     * Get all the postsof an author
     * 
     * @param int $user_Id Id of user
     * 
     * @return array of posts if posts exists 
     * @return null if posts not exists
     */
    public function getUserPosts($user_Id)
    {
        $req = $this->database()->prepare(
            'SELECT post.id, post.title, user.authorName,
             UNIX_TIMESTAMP(post.lastDateModif) AS lastDateModif,
             published
             FROM post
             INNER JOIN user ON post.user_id = user.id
             WHERE post.user_id = ?
             ORDER BY lastDateModif DESC'
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
     * @param Post $newPost Object Post
     * 
     * @return array Number of affected lines and las insert Id
     */
    public function addPost(Post $newPost)
    {
        $req = $this->database()->prepare(
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
                'user_id' => $_SESSION['user']->userId()
                )
        );
        return array($req->rowCount(),$this->database()->lastInsertId());
    }

        
    /**
     * Update a post
     *
     * @param Post $post Object Post
     * 
     * @return int Number of affected lines
     */
    public function updatePost(Post $post)
    {
        $req = $this->database()->prepare(
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
                'id' => $post ->postId()
            )
        );
        return $req->rowCount();
    }
    
    /**
     * Delete a post
     *
     * @param int $postId Id of post
     * 
     * @return int Number of affected lines
     */
    public function deletePost($postId)
    {
        $req = $this->database()->prepare(
            'DELETE FROM post WHERE id = ?'
        );
        $req->execute(array($postId));
        return $req->rowCount();
    }

    /**
     * Count number of posts
     * 
     * @return int Number of posts
     */
    public function countPosts()
    {
        $req = $this->database()->query('SELECT COUNT(*) FROM post');
        $countPosts = $req->fetch();
        return $countPosts['COUNT(*)'];
    }

    /**
     * Count number of posts of an user
     * 
     * @param int $user_id Id of user
     * 
     * @return int Number of post of an user 
     */
    public function countUserPosts($user_id)
    {
        $req = $this->database()->prepare(
            'SELECT COUNT(*) 
             FROM post
             WHERE user_id = ?'
        );
        $req -> execute(array($user_id));
        $countPosts = $req->fetch();
        return $countPosts['COUNT(*)'];
    }

    /**
     * Get the date of the last published post
     * 
     * @return string DateTime format
     */
    public function lastDatePost()
    {
        $req = $this->database()->query(
            'SELECT MAX(lastDateModif) FROM post
             WHERE published = \'TRUE\''
        );
        $lastDateModif = $req->fetch();
        return $lastDateModif['MAX(lastDateModif)'];
    }

    /**
     * Get the date of the last published post af an user
     * 
     * @param int $user_id Id of user
     * 
     * @return string DateTime format
     */
    public function lastDateUserPost($user_id)
    {
        $req = $this->database()->prepare(
            'SELECT MAX(lastDateModif) FROM post
             WHERE published = \'TRUE\'
             AND user_id = ?'
        );
        $req -> execute(array($user_id));
        $lastDateModif = $req->fetch();
        return $lastDateModif['MAX(lastDateModif)'];
    }

    /**
     * Get the number of line contains picture post name
     * 
     * @param string $picture Name of picture
     * 
     * @return int Number of lines
     */
    public function getPostImg($picture)
    {
        $req = $this->database()->prepare('SELECT COUNT(*) FROM post WHERE picture = ?');
        $req -> execute(array($picture));
        $result = $req -> fetch();
        return $result['COUNT(*)'];
    }

}