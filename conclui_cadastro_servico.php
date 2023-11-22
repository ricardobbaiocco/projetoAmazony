<?php
require_once 'conexao.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nomeServico = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoriaNome = $_POST['categoria'];
    
    // Inicializa a resposta como um array
    $response = array();

    // Obtenha o ID da categoria mapeando o nome para o ID
    $query = "SELECT idCategoria FROM categoria WHERE nomeCategoria = ?";
    $params = array($categoriaNome);
    $stmt = sqlsrv_query($conexao, $query, $params);

    if ($stmt && sqlsrv_fetch($stmt)) {
        $categoriaId = sqlsrv_get_field($stmt, 0);
    } else {
        // Resposta JSON para o JavaScript em caso de erro
        $response['success'] = false;
        $response['message'] = 'Erro ao obter o ID da categoria.';
        echo json_encode($response);
        exit; // Saia do script em caso de erro.
    }

    // Defina o diretório de upload (crie-o se não existir)
    $uploadDirectory = 'uploads/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }
    // Verifique se foi enviada uma imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $extensao = strtolower(pathinfo($fotoNome, PATHINFO_EXTENSION));

        // Verifica se a extensão do arquivo é uma das permitidas (png, jpg ou jpeg)
        $extensoesPermitidas = array('png', 'jpg', 'jpeg');
        if (in_array($extensao, $extensoesPermitidas)) {
            $destFile = $uploadDirectory . $fotoNome;

            // Move o arquivo para o diretório de upload
            if (move_uploaded_file($tempFile, $destFile)) {
                
                // Lê o conteúdo do arquivo de imagem como binário
                $fotoBinario = file_get_contents($destFile);

                // Preparar a consulta SQL para inserir os dados no banco de dados
                $query = "INSERT INTO servico (nomeServico, descricao,fk_categoria_idCategoria, foto) VALUES (?, ?, ?, CONVERT(varbinary(max), ?))";

                // Parâmetros para a consulta SQL
                $params = array($nomeServico, $descricao, $categoriaId, $fotoBinario);

                $stmt = sqlsrv_query($conexao, $query, $params);
              
                if ($stmt) {
                    // Resposta JSON para o JavaScript em caso de sucesso
                    $response['success'] = true;
                    $response['message'] = 'Serviço cadastrado com sucesso.';
                    echo json_encode($response);
                    exit;
                } else {
                    // Resposta JSON para o JavaScript em caso de erro
                    $response['success'] = false;
                    $response['message'] = 'Erro ao cadastrar serviço: ' . print_r(sqlsrv_errors(), true);
                    echo json_encode($response);
                    exit;
                }
            } else {
                // Resposta JSON para o JavaScript em caso de erro
                $response['success'] = false;
                $response['message'] = 'Erro ao mover o arquivo para o diretório de destino.';
                echo json_encode($response);
                exit;
            }
        } else {
            // Resposta JSON para o JavaScript em caso de erro
            $response['success'] = false;
            $response['message'] = 'Apenas arquivos PNG, JPG e JPEG são permitidos.';
            echo json_encode($response);
            exit;
        }
    } else {
        // Resposta JSON para o JavaScript em caso de erro
        $response['success'] = false;
        $response['message'] = 'Erro no upload da imagem: ' . $_FILES['foto']['error'];
        echo json_encode($response);
        exit;
    }
}
?>
