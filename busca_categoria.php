<?php
require_once 'conexao.php'; // Inclua o arquivo de conexão

if ($conexao) {
   

    // Consulta SQL para listar as categorias
    $sql = "SELECT nomeCategoria FROM categoria";

    // Executar a consulta
    $query = sqlsrv_query($conexao, $sql);

    if (!$query) {
        echo "Erro na consulta: " . print_r(sqlsrv_errors(), true);
    } else {
        // Inclua as opções dentro da variável $options
        $options = '<option value="" selected>Selecione a categoria</option>';

        while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
            $options .= '<option value="' . $row['nomeCategoria'] . '">' . $row['nomeCategoria'] . '</option>';
        }

        // Retorne as opções
        echo $options;
    }
} else {
    echo "Erro na conexão com o banco de dados.";
}
?>
