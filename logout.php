<?php
session_start();

// Destrua todas as variáveis de sessão
$_SESSION = array();

// Destrua a sessão
session_destroy();

// Redirecione o usuário de volta para a página de login após o logout
header("Location: login.html");
exit();
?>
