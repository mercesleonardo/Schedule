<?php

    require_once("templates/header.php");
    require_once("models/Contact.php");
    require_once("dao/ContactDAO.php");

    $contactDao = new ContactDAO($conn, $BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $q= filter_input(INPUT_GET, "q");

    $contacts = $contactDao->findByName($q, $userData->id);

?>

<div id="main-container" class="container-fluid">
        <h2 class="section-title" id="search-title">Você está buscando por: <span id="search-result"><?= $q ?></span></h2>
        <p class="section-description">
            Resultados de buscas retornados com base na sua pesquisa
        </p>
        <div class="contacts-container">
            <?php foreach($contacts as $contact): ?>                    
                <?php require("templates/contact_card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($contacts) == 0): ?>
                <p class="empty-list">Não há contatos para esta busca, <a href="<?= $BASE_URL ?>" class="back-link">voltar</a>.</p>
            <?php endif; ?>
        </div>
        
    </div>
<?php

    require_once("templates/footer.php")

?>