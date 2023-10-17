<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se os campos de CPF (usuário) e senha foram enviados
    if (isset($_POST['usuario']) && isset($_POST['senha'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Conecte-se ao banco de dados
        require_once 'conexao.php'; // Substitua pelo seu arquivo de conexão

        // Consulta SQL para verificar o usuário e a senha
        $query = "SELECT idPessoa, nome, fk_catPessoa_idCatPessoa FROM pessoa WHERE cpf = ? AND senha = ? AND fk_catPessoa_idCatPessoa = 1";
        $params = array(&$usuario, &$senha);

        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado) {
            // Verifique se a consulta retornou algum resultado
            if (sqlsrv_has_rows($resultado)) {
                // A consulta retornou resultados
                $row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
                $idPessoa = $row['idPessoa'];
                $nome = $row['nome'];
                $fk_catPessoa_idCatPessoa = $row['fk_catPessoa_idCatPessoa'];

                // Verifique o valor da fk_catPessoa_idCatPessoa
                if ($fk_catPessoa_idCatPessoa == 1) {
                    // Redirecionar para a página de cliente
                    header("Location: lista_produto.php?idPessoa=$idPessoa&nome=$nome");
                } elseif ($fk_catPessoa_idCatPessoa == 2) {
                    // Redirecionar para a página de funcionário
                    header("Location: tabela_produto.php?idPessoa=$idPessoa&nome=$nome");
                } else {
                    // Valor desconhecido na fk_catPessoa_idCatPessoa, exibir mensagem de erro
                    echo "Erro: Categoria desconhecida";
                }
            } else {
                // Nenhum resultado correspondente, exibir mensagem de erro
                echo "Erro: Usuário ou senha incorretos";
            }

            // Feche a consulta
            sqlsrv_free_stmt($resultado);
        } else {
            // Erro na consulta
            echo "Erro na consulta: " . print_r(sqlsrv_errors(), true);
        }

        // Feche a conexão com o SQL Server
        sqlsrv_close($conexao);
    } else {
        // Campos em falta
        echo "Erro: Campos obrigatórios em falta";
    }
} else {
    // Método de requisição incorreto
    echo "Erro: Método de requisição incorreto";
}
?>
