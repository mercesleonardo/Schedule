<?php

require_once("models/User.php");
require_once("models/Message.php");

class UserDAO implements UserDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data) {

        $user = new User;

        $user->id = $data["id"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->phone = $data["phone"];
        $user->password = $data["password"];
        $user->image = $data["image"];
        $user->bio = $data["bio"];
        $user->token = $data["token"];

        return $user;

    }

    public function create(User $user, $authUser = false) {


    }

    public function update(User $user, $redirect = true) {


    }

    public function verifyToken($protected = false) {


    }

    public function setTokenToSession($token, $redirect = true) {


    }

    public function authenticateUser($email, $password) {


    }

    public function findByEmail($email) {


    }

    public function findById($id) {


    }

    public function findByToken($token) {


    }

    public function destroyToken() {


    }

    public function changePassword(User $user) {


    }


}