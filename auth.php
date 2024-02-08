<?php
    require_once("templates/header.php");
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Digite sua senha">
                        </div>
                        <input class="btn card-btn" type="submit" value="Entrar">
                    </form>
                </div>
                <div class="col-md-4" id="register-container">
                    <h2>Criar conta</h2>
                    <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                        <input type="hidden" name="type" value="register">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Digite seu sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmação de senha:</label>
                            <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirme sua senha">
                        </div>
                        <input class="btn card-btn" type="submit" value="Registrar">
                    </form>
                </div>                
            </div>
        </div>
    </div>
<?php
    require_once("templates/footer.php");
?>