<?php

    require_once("config/globals.php");
    require_once("config/connection.php");
    require_once("models/Contact.php");
    require_once("models/Message.php");
    require_once("dao/ContactDAO.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $contactDao = new ContactDAO($conn, $BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    // Rescue form type
    $type = filter_input(INPUT_POST, "type");

    // Rescue user data
    $userData = $userDao->verifyToken();

    // Check the form type
    if ($type === "create") {

        //Getting input data
        $name = filter_input(INPUT_POST, "name");
        $phone = filter_input(INPUT_POST, "phone");
        $observations = filter_input(INPUT_POST, "observations");
        
        $contact = new Contact();

        // Minimum required data
        if(!empty($name) && !empty($phone)) {

            $contact->name = $name;
            $contact->phone = $phone;
            $contact->observations = $observations;
            $contact->users_id = $userData->id;

            $contactDao->create($contact);

        } else {

            $message->setMessage("Você precisa adicionar pelo menos: nome e contato!", "error", "back");
      
        }

    } else if($type === "delete") {

        //Getting input data
        $id = filter_input(INPUT_POST, "id");

        $contact = $contactDao->findById($id);

        if($contact) {

            //Check if contact belongs to the user
            if($contact->users_id === $userData->id) {

                $contactDao->destroy($contact->id);

            } else {

                $message->setMessage("Informações inválidas!", "error", "index.php");
        
            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
    
        }

    } else if($type === "update") {

        //Getting input data
        $name = filter_input(INPUT_POST, "name");
        $phone = filter_input(INPUT_POST, "phone");
        $observations = filter_input(INPUT_POST, "observations");
        $id = filter_input(INPUT_POST, "id");

        $contactData = $contactDao->findById($id);

        // Check if the contact exists
        if($contactData) {

            //Check if the contact belongs to the user
            if($contactData->users_id === $userData->id) {

                // Minimum required data
                if(!empty($name) && !empty($phone)) {

                    $contactData->name = $name;
                    $contactData->phone = $phone;
                    $contactData->observations = $observations;                    

                } else {

                    $message->setMessage("Você precisa adicionar pelo menos: nome e contato!", "error", "back");
          
                }

                $contactDao->update($contactData);

            } else {

                $message->setMessage("Informações inválidas!", "error", "index.php");
        
            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
      
        }

    }  else {

        $message->setMessage("Informações inválidas!", "error", "index.php");
    
    }

