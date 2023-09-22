<?php
$serverName = "localhost\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "projeto",
    "Uid" => "sa",
    "PWD" => "sa"
);

// Estabelecendo uma conexão com o SQL Server
$conexao = sqlsrv_connect($serverName, $connectionOptions);

if (!$conexao) {
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "Erro na conexão com o SQL Server: " . $error['message'] . "<br>";
    }
} else {
    //echo 'Conexão com o SQL Server estabelecida com sucesso!';
}


?>
