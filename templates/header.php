<?php
    require_once("config/globals.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    // require_once("config/process.php");
    require_once("config/connection.php");

    $message = new Message($BASE_URL);

    $flassMessage = $message->getMessage();

    //Clean up message
    if(!empty($flassMessage["msg"])) {

        $message->clearMessage();

    }

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda</title>
    <!-- <link rel="short icon" href="<?= $BASE_URL ?>img/moviestar.ico"/> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- CSS do projeto -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>
<body>
    <head>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a href="<?= $BASE_URL ?>index.php" class="navbar-brand">
                <img src="<?= $BASE_URL ?>img/logo.svg" alt="Schedule">
            </a>
            <div class="navbar-nav">
                <a href="<?= $BASE_URL ?>index.php" id="home-link" class="nav-link active">Agenda</a>
                <a href="<?= $BASE_URL ?>create.php" id="home-link" class="nav-link active">Adicionar novo contato</a>
            </div>
        </nav>
    </head>
    <?php if(!empty($flassMessage["msg"])): ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
        </div>
    <?php endif; ?>