<?php
require_once 'conexao.php'; // Certifique-se de que sua conexão com o banco de dados está incluída aqui

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nomeServico = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];

    // Lida com o upload da imagem
    $foto = null;
    if (isset($_FILES['foto'])) {
        $target_dir = 'uploads/'; // Diretório onde você deseja salvar as imagens
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verifica se a imagem é válida
        $check = getimagesize($_FILES['foto']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Move a imagem para o diretório de upload
        if ($uploadOk) {
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            $foto = $target_file; // Armazena o caminho da imagem
        }
    }

    // Insere os dados na tabela de serviço
    $query = "INSERT INTO servico (nomeServico, descricao, foto, fk_categoria_idCategoria) VALUES (?, ?, ?, ?)";
    $params = array($nomeServico, $descricao, $foto, $categoria);

    $stmt = sqlsrv_prepare($conexao, $query, $params);
    if (sqlsrv_execute($stmt)) {
        echo "Serviço cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o serviço: " . print_r(sqlsrv_errors(), true);
    }
}
?>
