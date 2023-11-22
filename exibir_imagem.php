<?php
// Inclua a conexão com o banco de dados
require_once 'conexao.php';

// Verifique se a conexão foi estabelecida com sucesso
if ($conexao) {
    // Recupere o ID da imagem a ser exibida (você pode ajustar isso conforme necessário)
    if (isset($_GET['imagem_id'])) {
        $imagem_id = $_GET['imagem_id'];

        // Consulta SQL para obter os dados da imagem com base no ID
        $query = "SELECT foto FROM produto WHERE id = ?"; // Substitua "produto" e "id" pelos nomes corretos da tabela e coluna

        // Preparar a consulta
        $stmt = sqlsrv_prepare($conexao, $query, array(&$imagem_id));

        if (sqlsrv_execute($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($row) {
                // Defina o tipo de conteúdo como imagem
                header('Content-Type: image/jpeg'); // Ou 'image/png' se sua imagem for em formato PNG

                // Saída da imagem diretamente
                echo $row['foto'];

                // Feche a conexão com o SQL Server
                sqlsrv_close($conexao);
                exit();
            }
        }
    }
}

// Se algo deu errado ou a imagem não foi encontrada, você pode exibir uma imagem padrão ou mensagem de erro
header('Content-Type: image/png'); // Ou qualquer outro tipo de conteúdo que você deseja exibir
readfile('caminho_para_imagem_padrao.png'); // Substitua pelo caminho da imagem padrão
?>
