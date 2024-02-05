<?php

require_once("config/globals.php");
require_once("config/connection.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// Rescue form type
$type = filter_input(INPUT_POST, "type");

//Checking the form type
if($type === "register") {

    $email = filter_input(INPUT_POST, "email");
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $phone = filter_input(INPUT_POST, "phone");
    $bio = filter_input(INPUT_POST, "bio");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Minimum data check required
    if($email && $name && $lastname && $password) {

        // Checking if the password is correct
        if($password === $confirmpassword) {

            //Checking if the email is already registered in the system
            if($userDao->findByEmail($email) === false) {

                $user = new User();

                // Upload user image
                if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/png", "image/jpg"];
                    $jpgArray = ["image/jpg", "image/jpeg"];

                    // Checking image type
                    if(in_array($image["type"], $imageTypes)) {

                        // Checking if image type is jpg or jpeg
                        if(in_array($image["type"], $jpgArray)) {

                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        
                        // PGN Image
                        } else {

                            $imageFile = imagecreatefrompng($image["tmp_name"]);

                        }

                        // Generating the image name
                        $imageName = $user->imageGenerateName();

                        imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                        $user->image = $imageName;

                    } else {

                        $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
              
                    }

                }

                // Creating the token and password
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->email = $email;
                $user->name = $name;
                $user->lastname = $lastname;
                $user->phone = $phone;
                $user->bio = $bio;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
                
            } else {
          
                // Sends an error message, the email already exists
                $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
    
            }

        } else {

            // Sends an error message, passwords do not match
            $message->setMessage("As senhas não são iguais.", "error", "back");
    
        }

    } else {

        // Sends an error message, incomplete data
        $message->setMessage("Você precisa preencher pelo menos: e-mail, nome e sobrenome", "error", "back");
  
    }

} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");
}