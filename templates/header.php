<?php
    require_once("config/globals.php");
    require_once("config/process.php");

    //Clean up message
    if(isset($_SESSION['msg'])) {
        $printMsg = $_SESSION['msg'];
        $_SESSION['msg'] = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- CSS -->
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