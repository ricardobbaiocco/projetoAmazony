<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // O usuário não está autenticado, redirecione-o para a página de login
    header("Location: login.html"); // ou outra página de login
    exit();
}
?>
