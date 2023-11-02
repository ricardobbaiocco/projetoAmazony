<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $response = array();

    // Conecte-se ao banco de dados (substitua pelas suas credenciais)
    require_once 'conexao.php';

    // Consulta SQL para verificar o usuário e a senha
    $query = "SELECT idPessoa, nome, fk_catPessoa_idCatPessoa FROM pessoa WHERE cpf = ? AND senha = ? AND fk_catPessoa_idCatPessoa = 1";

    // Use a função sqlsrv_query com os parâmetros diretamente, não é necessário criar um array de parâmetros.
    $resultado = sqlsrv_query($conexao, $query, array($usuario, $senha));

    if ($resultado === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($resultado)) {
        // Inicie a sessão
        session_start();

        // Armazene informações do usuário na sessão (ajuste isso conforme sua necessidade)
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $usuario;
        // Adicione mais informações do usuário à sessão, se necessário

        $response['success'] = true;
        $response['message'] = 'Sucesso no login';
    } else {
        $response['success'] = false;
        $response['message'] = 'Erro ao fazer login';
    }

    echo json_encode($response);

    // Feche a conexão com o banco de dados
    sqlsrv_close($conexao);
}
?>
