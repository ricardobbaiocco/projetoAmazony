<?php
require_once 'conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Consulta SQL para excluir o produto com base no ID
    $query = "DELETE FROM produto WHERE idProduto = ?";
    $params = array(&$idProduto);
    $resultado = sqlsrv_query($conexao, $query, $params);

    if ($resultado) {
        $response = array('success' => true, 'message' => 'Produto excluído com sucesso.');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Erro ao excluir o produto.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'ID do produto não fornecido.');
    echo json_encode($response);
}
?>
