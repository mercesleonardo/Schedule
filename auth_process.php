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
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Minimum data check required
    if($email && $name && $lastname && $password) {

        // Checking if the password is correct
        if($password === $confirmpassword) {

            //Checking if the email is already registered in the system
            if($userDao->findByEmail($email) === false) {

                $user = new User();

                // Creating the token and password
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->email = $email;
                $user->name = $name;
                $user->lastname = $lastname;
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

} else if($type === "login") {

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Try to authenticate the user
    if($userDao->authenticateUser($email, $password)) {

        $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
    
    // Redirect the user if authentication fails
    } else {

        $message->setMessage("Usuario e / ou senha incorretos.", "error", "back");

    }

} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");
}