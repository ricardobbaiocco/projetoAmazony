<?php
echo "Este arquivo foi executado.";
// Conexão com o banco de dados
require_once 'conexao.php';

// Consulta SQL para obter as categorias
$query = "SELECT idCategoria, nomeCategoria FROM categoria";
$result = sqlsrv_query($conexao, $query);
echo "parou aqui.";
if (!$result) {
    die(print_r(sqlsrv_errors(), true)); // Isso exibirá informações detalhadas de erro
}
// Inicialize um array para armazenar as categorias
$categorias = array();
echo "<br>denovo.";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $categorias[] = $row;
}
echo "<br>aqui também chegou .";
// Retorne os resultados como JSON
echo json_encode($categorias);
echo "Este arquivo foi executado.";
?>
