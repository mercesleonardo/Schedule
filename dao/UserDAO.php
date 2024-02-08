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

        $stmt = $this->conn->prepare("INSERT INTO users (email, name, lastname, password, token) VALUES (:email, :name, :lastname, :password, :token)");

        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        // Authenticate user, if auth is true
        if($authUser) {

            $this->setTokenToSession($user->token);

        }

    }

    public function update(User $user, $redirect = true) {

        $stmt = $this->conn->prepare("UPDATE users SET email = :email, name = :name, lastname = :lastname, phone = :phone, bio = :bio, image = :image, token = :token, password = :password WHERE id = :id");

        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":phone", $user->phone);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        // Redirect to the user's profile
        if($redirect) {

            $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

        }

    }

    public function verifyToken($protected = false) {

        if(!empty($_SESSION["token"])) {

            // Get the session token
            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if($user) {

                return $user;

            // Redirect unauthenticated user
            } else if($protected) {

                $this->message->setMessage("Faça a autenticação para acessar esta página", "error", "auth.php");

            }

        // Redirect unauthenticated user    
        }  else if($protected) {

            $this->message->setMessage("Faça a autenticação para acessar esta página", "error", "auth.php");

        }

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

        $user = $this->findByEmail($email);

        if($user) {

            // Check if password is correct
            if(password_verify($password, $user->password)) {

                // Generate a token and insert it into the session.
                $token = $user->generateToken();

                $this->setTokenToSession($token, false);

                // Authenticate the user's token
                $user->token = $token;

                $this->update($user, false);

                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

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

        if($token != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

            $stmt->bindParam(":token", $token);

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

    public function destroyToken() {

        // Remove the token from the session
        $_SESSION["token"] = "";

        // Logout the user and redirect back to the login page
        $this->message->setMessage("Você fez o logout com sucesso!", "success", "auth.php");

    }

    public function changePassword(User $user) {

        $stmt = $this->conn->prepare("UPDATE users SET password = :password Where id = :id");

        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        // Redirect to user profile
        $this->message->setMessage("Senha atualizada com sucesso!", "success", "editprofile.php");

    }


}