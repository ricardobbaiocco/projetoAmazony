<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $response = array();

    // Conecte-se ao banco de dados (substitua pelas suas credenciais)
    require_once 'conexao.php';

    // Consulta SQL para verificar o usuário e a senha
    $query = "SELECT idPessoa, nome, fk_catPessoa_idCatPessoa FROM pessoa WHERE cpf = ? AND senha = ?";
    $resultado = sqlsrv_query($conexao, $query, array($usuario, $senha));

    if ($resultado === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($resultado)) {
        // Inicie a sessão
        session_start();

        // Obtenha o valor de fk_catPessoa_idCatPessoa
        $row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $categoriaPessoa = $row['fk_catPessoa_idCatPessoa'];

        // Armazene informações do usuário na sessão (ajuste isso conforme sua necessidade)
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $usuario;
        // Adicione mais informações do usuário à sessão, se necessário

        $response['success'] = true;
        $response['message'] = 'Sucesso no login';

        // Verifique a categoria do usuário e redirecione com base nisso
        if ($categoriaPessoa == 1) {
            $response['redirect'] = 'index.html'; // Redirecionar para a página 1
        } elseif ($categoriaPessoa == 2) {
            $response['redirect'] = 'pagina_funcionario.html'; // Redirecionar para a página 2
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Erro ao fazer login';
    }

    echo json_encode($response);

    // Feche a conexão com o banco de dados
    sqlsrv_close($conexao);
}
?>
