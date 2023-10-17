<?php
require_once 'conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Consulta SQL para excluir o produto com base no ID
    $query = "DELETE FROM produto WHERE idProduto = ?";
    $params = array(&$idProduto);
    $resultado = sqlsrv_query($conexao, $query, $params);

    if ($resultado) {
        // Defina uma mensagem de exclusão bem-sucedida
        echo '<div class="alert alert-success" role="alert">Produto excluído com sucesso.</div>';
        echo '<script>setTimeout(function(){ window.location = "tabela_produto.php"; }, 2000);</script>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Erro ao excluir o produto: ' . print_r(sqlsrv_errors(), true) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID do produto não fornecido</div>';
}
?>
