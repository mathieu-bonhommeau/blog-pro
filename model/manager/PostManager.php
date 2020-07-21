<?php

class PostManager extends Manager 
{ 

    public function getPosts()
    {
        $req = $this->db()->query('SELECT * FROM post ORDER BY lastDateModif DESC');
        return $req;
    }

    public function getPost($id)
    {
        $req = $this->db()->prepare('SELECT * FROM post WHERE id = ?');
        $req->execute(array($id));
        return $data = $req->fetch(PDO::FETCH_ASSOC);
    }

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
        return $req;
    }

    public function updatePost($title, $chapo, $content)
    {
        //$this->
    }

}