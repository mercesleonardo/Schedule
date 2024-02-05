<?php
    require_once("templates/header.php");
?>
    <div class="container">
        <?php require_once("templates/backbtn.html"); ?>
        <h1 id="main-title">Criar usuário</h1>
        <form id="create-form" action="<?= $BASE_URL ?>auth_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="register">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu email">
            </div>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Digite seu nome">
            </div>
            <div class="form-group">
                <label for="lastname">Sobrenome:</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Digite seu sobrenome">
            </div>
            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Digite seu telefone">
            </div>            
            <div class="form-group">
              <label for="bio">Sobre você:</label>
              <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte quem você é, o que faz e onde trabalha..."></textarea>
            </div>
            <div class="form-group">
              <label for="image">Foto:</label>
              <input type="file" class="form-control-file" name="image">
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Digite sua senha">
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirmação de senha:</label>
                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirme sua senha">
            </div>
            <input class="btn btn-primary" type="submit" value="Registrar">
        </form>
    </div>
<?php
    require_once("templates/footer.php");
?>