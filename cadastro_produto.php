<?php
require_once 'conexao.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $valor = $_POST['valor'];
    
    // Processar a imagem enviada
    $foto = file_get_contents($_FILES['foto']['tmp_name']);
    // Preparar a consulta SQL para inserir os dados no banco de dados
    $query = "INSERT INTO produto (nomeProduto, descricao, fk_categoria_idCategoria, valorProduto, foto) VALUES ('$nome', '$descricao', $categoria, $valor, ?)";

    // Preparar a declaração SQL com parâmetros
    $stmt = sqlsrv_prepare($conexao, $query, array(array(sqlsrv_phptype::BINARY, $foto, SQLSRV_PARAM_IN, SQLSRV_SQLTYPE_VARBINARY('max'))));
    
    // busca as categorias cadastradas no banco 
    $query = "SELECT nomeCategoria FROM categoria";
    $result = sqlsrv_query($conexao, $query);

    // Inicialize um array para armazenar as categorias
    $categorias = array();

    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $categorias[] = $row;
    }
    var_dump($categorias);

    // Renderize as opções no formulário HTML
    foreach ($categorias as $categoria) {
        echo "<option>{$categoria['nomeCategoria']}</option>";
    }

    // Executar a consulta SQL
    if (sqlsrv_execute($stmt)) {
        echo 'Produto cadastrado com sucesso.';
    } else {
        echo 'Erro ao cadastrar produto: ' . print_r(sqlsrv_errors(), true);
    }
}
?>
