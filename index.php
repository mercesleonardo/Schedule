<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/ContactDAO.php");

    $user = new User();

    $userDao = new UserDAO($conn, $BASE_URL);

    $contactDao = new ContactDAO($conn, $BASE_URL);

    // Check if the user is authenticated
    $userData = $userDao->verifyToken(true);

    $userContacts = $contactDao->getContactsByUserId($userData->id); 

?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Minha Agenda</h2>
    <p class="section-description">Adicione ou atualize as informações dos seus contatos</p>
    <?php if($userContacts): ?>
        <div class="col-md-12" id="add-contact-container">
            <a href="<?= $BASE_URL ?>create_contact.php" class="btn card-btn">
                <i class="fas fa-plus"></i> Adicionar contato
            </a>
            </div>
            <div class="col-md-12" id="contacts-dashboard">
            <table class="table">
                <thead>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Contato</th>
                <th scope="col" class="actions-column">Ações</th>
                </thead>
                <tbody>
                <?php foreach($userContacts as $contact): ?>
                    <tr>
                        <td scope="row"><?= $contact->id ?></td>
                        <td><a href="<?= $BASE_URL ?>show_contact.php?id=<?= $contact->id ?>" class="table-contact-title"><?= $contact->name ?></a></td>            
                        <td><?= $contact->phone ?></td>            
                        <td class="actions-column">
                        <a href="<?= $BASE_URL ?>edit_contact.php?id=<?= $contact->id ?>" class="edit-btn">
                            <i class="far fa-edit"></i> Editar
                        </a>
                        <form action="<?= $BASE_URL ?>contact_process.php" method="POST">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $contact->id ?>">
                            <button type="submit" class="delete-btn">
                            <i class="fas fa-times"></i> Deletar
                            </button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p id="empty-list-text">Ainda não há contatos na sua agenda, <a href="<?= $BASE_URL ?>create_contact.php">Clique aqui para adicionar</a>.</p>
    <?php endif; ?>
  </div>

<?php
    require_once("templates/footer.php");
?>
    
