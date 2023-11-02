<?php
require_once 'conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idServico = $_GET['id'];

    // Consulta SQL para excluir o produto com base no ID
    $query = "DELETE FROM servico WHERE idServico = ?";
    $params = array(&$idServico);
    $resultado = sqlsrv_query($conexao, $query, $params);

    if ($resultado) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'error' => print_r(sqlsrv_errors(), true)));
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID do servico não fornecido</div>';
}
?>
