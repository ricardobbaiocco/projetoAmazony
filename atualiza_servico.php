<?php
require_once('conexao.php');

header('Content-Type: application/json'); // Definir o cabeçalho para JSON

$response = array('success' => false); // Comece com a resposta definida como falha

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $idServico = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    

    // Lógica para lidar com a imagem, se ela for alterada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $fotoBinario = file_get_contents($tempFile);

        // Atualizar a imagem no banco de dados
        $query = "UPDATE servico SET nomeServico = ?, descricao = ?, fk_categoria_idCategoria = ?, foto = CONVERT(varbinary(max), ?) WHERE idServico = ?";
        $params = array(&$nome, &$descricao, &$categoria, $fotoBinario, &$idServico);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado) {
            $response['success'] = true;
            $response['message'] = 'Serviço alterado com sucesso!';
        } else {
            $response['success'] = false;
            $response['error'] = 'Erro ao editar serviço.';
        }
    } else {
        // Consulta SQL para atualizar as informações do produto, excluindo a atualização da imagem
        $query = "UPDATE servico SET nomeServico = ?, descricao = ?, fk_categoria_idCategoria = ? WHERE idServico = ?";
        $params = array(&$nome, &$descricao, &$categoria, &$idServico);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado) {
            $response['success'] = true;
            $response['message'] = 'Serviço alterado com sucesso!';
        } else {
            $response['success'] = false;
            $response['error'] = 'Erro ao editar serviço.';
        }
    }
} else {
    $response['error'] = 'ID do servico não fornecido';
}

echo json_encode($response); // Responda com a estrutura JSON
?>
