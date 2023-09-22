<?php
// Estabelecer conexão com o banco de dados
require_once 'conexao.php';

$response = array();

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obter os dados do formulário
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $dtnascimento = $_POST['dtnascimento'];
  $cep = $_POST['cep'];
  $rua = $_POST['rua'];
  $numero = $_POST['numero'];
  $complemento = $_POST['complemento'];
  $ibge = $_POST['ibge'];
  $bairro = $_POST['bairro'];
  $cidade = $_POST['cidade'];
  $uf = $_POST['uf'];

  // Preparar a consulta SQL para inserir os dados no banco de dados
  //categoria padrão para cliente
  $idCategoriaPadrao = 1;
  $query = "INSERT INTO pessoa (nome, cpf, nascimento, cep, rua, numero, complemento, ibge, bairro, cidade, estado, fk_catPessoa_idCatPessoa) VALUES ('$nome', '$cpf', '$dtnascimento', '$cep', '$rua', '$numero', '$complemento', '$ibge', '$bairro', '$cidade', '$uf', $idCategoriaPadrao)";

  // Executar a consulta SQL
  $stmt = sqlsrv_query($conexao, $query);

  if ($stmt) {
    $response['success'] = true;
    $response['message'] = 'Cliente cadastrado com sucesso.';
  } else {
    $response['success'] = false;
    $response['message'] = 'Erro ao cadastrar cliente: ' . print_r(sqlsrv_errors(), true);
  }

  // Converter o array de resposta em JSON
  echo json_encode($response);
}
?>
