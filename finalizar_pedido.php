<?php
// Inclua o arquivo de conexão
require_once 'conexao.php';
print_r("depois da conexao");
$data = file_get_contents('php://input');
print_r("depois do data");
$carrinho = json_decode($data, true);
print_r("depois do carrinho");
print_r($carrinho);
if ($carrinho) {
    // Listando os produtos
    foreach ($carrinho['produtos'] as $produto) {
        echo "ID: " . $produto['id'] . "<br>";
        echo "Nome: " . $produto['nome'] . "<br>";
        echo "Quantidade: " . $produto['quantidade'] . "<br>";
        echo "Preço: " . $produto['preco'] . "<br><br>";
    }
}
?>
