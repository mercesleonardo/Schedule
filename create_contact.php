<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    // Check if the user is authenticated
    $userData = $userDao->verifyToken(true);

?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-contact-container">
        <h1 class="page-title">Adicionar Contato</h1>
        <p class="page-description">Adicione seus contatos preferidos</p>
        <form action="<?= $BASE_URL ?>contact_process.php" method="POST" id="add-contact-form">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" placeholder="Digite o nome do contato" class="form-control">
            </div>                
            <div class="form-group">
                <label for="phone">Contato:</label>
                <input type="tel" name="phone" id="phone" placeholder="Digite telefone" class="form-control">
            </div>               
            <div class="form-group">
                <label for="observations">Descrição:</label>
                <textarea name="observations" id="observations" rows="5" placeholder="Informações sobre o contato" class="form-control"></textarea>
            </div>
            <input type="submit" value="Adicionar contato" class="btn card-btn">
        </form>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>