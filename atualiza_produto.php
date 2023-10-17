<?php
require_once('conexao.php');

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $idProduto = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $valor = $_POST['valor'];

    // Lógica para lidar com a imagem, se ela for alterada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $fotoBinario = file_get_contents($tempFile);

        // Atualizar a imagem no banco de dados
        $query = "UPDATE produto SET nomeProduto = ?, descricao = ?, fk_categoria_idCategoria = ?, valorProduto = ?, foto = CONVERT(varbinary(max), ?) WHERE idProduto = ?";
        $params = array(&$nome, &$descricao, &$categoria, &$valor, $fotoBinario, &$idProduto);
        $resultado = sqlsrv_query($conexao, $query, $params);


        if ($resultado) {
            echo '<div class="alert alert-success" role="alert">Produto atualizado com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erro ao atualizar a imagem do produto: ' . print_r(sqlsrv_errors(), true) . '</div>';
        }
    } else {
        // Consulta SQL para atualizar as informações do produto, excluindo a atualização da imagem
        $query = "UPDATE produto SET nomeProduto = ?, descricao = ?, fk_categoria_idCategoria = ?, valorProduto = ? WHERE idProduto = ?";
        $params = array(&$nome, &$descricao, &$categoria, &$valor, &$idProduto);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado) {
            echo '<div class="alert alert-success" role="alert">Produto atualizado com sucesso</div>';
            echo '<script>setTimeout(function(){ window.location = "tabela_produto.php"; }, 2000);</script>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erro ao atualizar o produto: ' . print_r(sqlsrv_errors(), true) . '</div>';
        }
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID do produto não fornecido</div>';
}
?>
