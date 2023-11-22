<?php
require_once('conexao.php');

header('Content-Type: application/json'); // Definir o cabeçalho para JSON

$response = array('success' => false); // Comece com a resposta definida como falha

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
            $response['success'] = true;
            $response['message'] = 'Produto alterado com sucesso!';
        } else {
            $response['success'] = false;
            $response['error'] = 'Erro ao editar produto.';
        }
    } else {
        // Consulta SQL para atualizar as informações do produto, excluindo a atualização da imagem
        $query = "UPDATE produto SET nomeProduto = ?, descricao = ?, fk_categoria_idCategoria = ?, valorProduto = ? WHERE idProduto = ?";
        $params = array(&$nome, &$descricao, &$categoria, &$valor, &$idProduto);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado) {
            $response['success'] = true;
            $response['message'] = 'Produto alterado com sucesso!';
        } else {
            $response['success'] = false;
            $response['error'] = 'Erro ao editar produto.';
        }
    }
} else {
    $response['error'] = 'ID do produto não fornecido';
}

echo json_encode($response); // Responda com a estrutura JSON
?>
