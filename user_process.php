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

    // Update user
    if($type === "update") {

        // Rescue user data
        $userData = $userDao->verifyToken();

        // Rescue post data
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");
        $phone = filter_input(INPUT_POST, "phone");

        // Create a new user object
        $user = new User();

        // Fill the user data
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;
        $userData->phone = $phone;

        // Upload image
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // check image types
            if(in_array($image["type"], $imageTypes)) {

                // check if the image type is jpeg or jpg
                if (in_array($image["type"], $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                // png image   
                } else {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }

                // Delete the old image file if it exists
                if (!empty($userData->image)) {

                    $oldImage = "./img/users/" . $userData->image;

                    if (file_exists($oldImage)) {

                        unlink($oldImage);

                    }
                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                $userData->image = $imageName;

            } else {

            $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

            }

        }

        $userDao->update($userData);
    
    // Change user's password    
    } else if($type === "changepassword") {

        // Rescue post data
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // Rescue user data
        $userData = $userDao->verifyToken();

        $id = $userData->id;

        if($password == $confirmpassword) {

            // Create new user object
            $user = new User;

            $finalPassword = $user->generatePassword($password);

            $user->password = $finalPassword;
            $user->id = $id;

            $userDao->changePassword($user);

        } else {
      
            $message->setMessage("As senhas não são iguais!", "error", "back");
    
        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");
    
    }