<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/ContactDAO.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    // Check if the user is authenticated
    $userData = $userDao->verifyToken(true);

    $contactDao = new ContactDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        $message->setMessage("O contato não foi encontrado!", "error", "index.php");

    } else {

        $contact = $contactDao->findById($id);

        // Check if the contact exists
        if(!$contact) {

            $message->setMessage("O contato não foi encontrado!", "error", "index.php");

        }

    }

?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-contact-container">
        <h1 class="page-title"><?= $contact->name ?></h1>
        <p class="page-description">Altere os dados do contato no formulário abaixo:</p>
        <form action="<?= $BASE_URL ?>contact_process.php" method="POST" id="add-contact-form">
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="id" value="<?= $contact->id ?>">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" placeholder="Digite o nome do contato" value="<?= $contact->name ?>" class="form-control">
            </div>                
            <div class="form-group">
                <label for="phone">Contato:</label>
                <input type="tel" name="phone" id="phone" placeholder="Digite telefone" value="<?= $contact->phone ?>" class="form-control">
            </div>               
            <div class="form-group">
                <label for="observations">Descrição:</label>
                <textarea name="observations" id="observations" rows="5" placeholder="Informações sobre o contato" class="form-control"><?= $contact->observations ?></textarea>
            </div>
            <input type="submit" value="Editar contato" class="btn card-btn">
        </form>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>