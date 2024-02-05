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

        $stmt = $this->conn->prepare("INSERT INTO users (email, name, lastname, phone, image, bio, password, token) VALUES (:email, :name, :lastname, :phone, :image, :bio, :password, :token)");

        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":phone", $user->phone);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        // Authenticate user, if auth is true
        if($authUser) {

            $this->setTokenToSession($user->token);

        }

    }

    public function update(User $user, $redirect = true) {


    }

    public function verifyToken($protected = false) {


    }

    public function setTokenToSession($token, $redirect = true) {

        // Save token in session
        $_SESSION["token"] = $token;

        if($redirect) {

            // Redirect to user profile page
            $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

        }

    }

    public function authenticateUser($email, $password) {


    }

    public function findByEmail($email) {

        if($email != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {

                return false;

            }

        } else {

            return false;

        }

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