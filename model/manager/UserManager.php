<?php

namespace blog\model;

class UserManager extends Manager 
{ 
    public function getUsers()
    {
        $req = $this->db()->query(
            'SELECT user.id, user.userName, user.password, 
            user.profilPicture, user.authorName, usertype.type
            FROM user
            INNER JOIN usertype ON user.userType_id = usertype.id
            ORDER BY usertype.type'
        );
        return $req;
    }

    public function getUser($info)
    {
        if (is_int($info)) {
            $req = $this->db()->prepare(
                'SELECT user.id, user.userName, user.password, 
                user.profilPicture, user.authorName, usertype.type
                FROM user
                INNER JOIN usertype ON user.userType_id = usertype.id
                WHERE user.id = ?
                ORDER BY usertype.type'
            );
            $req -> execute(array($info));
        } elseif (is_string($info)) {
            $req = $this->db()->prepare(
                'SELECT user.id, user.userName, user.password, 
                user.profilPicture, user.authorName, usertype.type
                FROM user
                INNER JOIN usertype ON user.userType_id = usertype.id
                WHERE user.userName = ?
                ORDER BY usertype.type'
            );
        }
        return $data = $req->fetch(PDO::FETCH_ASSOC); 
    }

    public function addUser(
        $userName, $password, $profilPicture, $authorName, $userType_id
    ) {
        $req = $this->db()->prepare(
            'INSERT INTO user 
            (userName, password, profilPicture, authorName, userType_id)
            VALUES (:userName, :password, :profilPicture, :authorName, :userType_id)'
        );
        $req -> execute(
            array(
                'userName' => $userName,
                'password' => $password,
                'profilPicture' => $profilPicture,
                'authorName' => $authorName,
                'userType_id' => $userType_id
            )
        );
        return $req->rowCount();
    }

    public function updateUser(
        $id, $userName, $password, $profilPicture, $authorName, $userType_id
    ) {
        $req = $this->db()->prepare(
            'UPDATE user SET
            userName = :userName, password = :password, 
            profilPicture = :profilPicture, authorName = :authorName, 
            userType_id = :userType_id
            WHERE id = :id'
        );
        $req -> execute(
            array(
                'userName' => $userName,
                'password' => $password,
                'profilPicture' => $profilPicture,
                'authorName' => $authorName,
                'userType_id' => $userType_id,
                'id' => $id
            )
        );
        return $req->rowCount();
    }

    public function deleteUser($id)
    {
        $req = $this->db()->prepare(
            'DELETE FROM user WHERE id = ?'
        );
        $req -> execute(array($id));
        return $req->rowCount();
    }
}