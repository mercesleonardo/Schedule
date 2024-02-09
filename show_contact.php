<?php

    require_once("templates/header.php");
    require_once("models/Contact.php");
    require_once("dao/ContactDAO.php");

    // Get the contact id
    $id = filter_input(INPUT_GET, "id");

    $contact;

    $contactDao = new ContactDAO($conn, $BASE_URL);

    if(empty($id)) {

        $message->setMessage("O contato não foi encontrado!", "error", "index.php");

    } else {

        $contact = $contactDao->findById($id);
        
        // Check if the contact exists
        if(!$contact) {

            $message->setMessage("O contato não foi encontrado!", "error", "index.php");

        }

    }

    // Check if the contact is from the user
    $userOwnsContact = false;

    if(!empty($userData)) {

        if($userData->id === $contact->users_id) {

            $userOwnsContact = true;

        }

    }

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
      <div class="row profile-container">
        <div class="col-md-12 about-container">
          <h1 class="page-title"><?= $contact->name ?></h1>
          <h1 class=""><?= $contact->phone ?></h1>
          <h3 class="about-title">Sobre:</h3>
          <?php if(!empty($contact->observations)): ?>
            <p class="profile-description"><?= $contact->observations ?></p>
          <?php else: ?>
            <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
          <?php endif; ?>
        </div>        
      </div>
    </div>
  </div>

<?php
    require_once("templates/footer.php");
?>
    
