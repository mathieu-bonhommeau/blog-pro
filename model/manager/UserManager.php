<?php

namespace model;

class UserManager extends Manager 
{ 
    public function getUsers()
    {
        $req = $this->database()->query(
            'SELECT user.id, user.userName, user.password, 
            user.profilPicture, user.authorName, user.registerDate, usertype.type
            FROM user
            INNER JOIN usertype ON user.userType_id = usertype.id
            ORDER BY usertype.type, user.registerDate DESC'
        );
        return $req;
    }

    public function getUser($info)
    {
        if (is_int($info)) {
            $req = $this->database()->prepare(
                'SELECT user.id, user.userName, user.password, user.userEmail, 
                user.profilPicture, user.authorName, user.registerDate, usertype.type
                FROM user
                INNER JOIN usertype ON user.userType_id = usertype.id
                WHERE user.id = ?'
            );
            $req -> execute(array($info));

        } elseif (is_string($info)) {
            $req = $this->database()->prepare(
                'SELECT user.id, user.userName, user.password, user.userEmail, 
                user.profilPicture, user.authorName, user.registerDate, usertype.type
                FROM user
                INNER JOIN usertype ON user.userType_id = usertype.id
                WHERE user.userName = ?
                ORDER BY usertype.type'
            );
            $req -> execute(array($info));  
        }

        $data = $req->fetch(\PDO::FETCH_ASSOC); 
        return $data;
    }

    public function addUser(User $user) 
    {
        $req = $this->database()->prepare(
            'SELECT id 
             FROM usertype
             WHERE type = ?'
        );
        $req -> execute(array($user->type()));
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $userType = $data['id'];

        $req = $this->database()->prepare(
            'INSERT INTO user 
            (userName, password, profilPicture, 
             authorName, registerDate, userType_id)
             VALUES (:userName, :password, :profilPicture, 
             :authorName, NOW(), :userType_id)'
        );
        $req -> execute(
            array(
                'userName' => $user->userName(),
                'password' => $user->password(),
                'profilPicture' => $user->profilPicture(),
                'authorName' => $user->authorName(),
                'userType_id' => $userType
            )
        );
        return $req->rowCount();
    }

    public function getTypeId($userType)
    {
        $req = $this->database()->prepare(
            'SELECT id 
             FROM usertype
             WHERE type = ?'
        );
        $req -> execute(array($userType));
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function updateUser(User $user) 
    {
        $userTypeId = $this->getTypeId($user->type());

        $req = $this->database()->prepare(
            'UPDATE user SET
            userName = :userName, password = :password, userEmail = :userEmail, 
            profilPicture = :profilPicture, authorName = :authorName, 
            userType_id = :userType_id
            WHERE id = :id'
        );
        $req -> execute(
            array(
                'userName' => $user->userName(),
                'password' => $user->password(),
                'userEmail' => $user->userEmail(),
                'profilPicture' => basename($user->profilPicture()),
                'authorName' => $user->authorName(),
                'userType_id' => $userTypeId,
                'id' => $user->userId()
            )
        );
        return $req->rowCount();
    }

    public function deleteUser($userId)
    {
        $req = $this->database()->prepare(
            'DELETE FROM user WHERE id = ?'
        );
        $req -> execute(array($userId));
        return $req->rowCount();
    }

    public function countUser()
    {
        $req = $this->database()->query('SELECT COUNT(*) FROM user');

        $data = $req->fetch();
        return $data['COUNT(*)'];
    }

    public function lastAddedUser()
    {
        $req = $this->database()->query(
            'SELECT userName, registerDate FROM user
                WHERE registerDate = (
                    SELECT MAX(registerDate) 
                    FROM user
                    )'
        );
        return $data = $req->fetch(\PDO::FETCH_ASSOC);
    }
}