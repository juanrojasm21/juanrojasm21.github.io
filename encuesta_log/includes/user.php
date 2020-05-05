<?php

include_once 'db.php';

class User extends DB{

    private $nombre;
    private $username;
    private $lastDate;

    public function userExists($user, $pass){
        $md5pass = md5($pass);

        $query = $this->connect()->prepare('SELECT * FROM users WHERE user = :user AND pass = :pass');
        $query->execute(['user' => $user, 'pass' => $md5pass]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user){
        $query = $this->connect()->prepare('SELECT * FROM users WHERE user = :user');
        $query->execute(['user' => $user]);

        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->username = $currentUser['user'];
            $this->lastDate = $currentUser['fechaIntento'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getFecha(){
        return $this->lastDate;
    }
}

?>
