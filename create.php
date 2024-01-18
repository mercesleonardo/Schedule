<?php
    include_once("templates/header.php");
?>
    <div class="container">
        <?php include_once("templates/backbtn.html"); ?>
        <h1 id="main-title">Criar contato</h1>
        <form id="create-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="name">Nome do contato:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone de contato:</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Insira seu telefone" required>
            </div>
            <div class="form-group">
                <label for="observations">Observações:</label>
                <textarea type="text" class="form-control" name="observations" id="observations" placeholder="Insira observações" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
<?php
    include_once("templates/footer.php");
?>