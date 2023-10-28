<?php
// Inclua o arquivo de conexão
require_once 'conexao.php';

// Receber os dados do carrinho
$post = json_decode(file_get_contents("php://input"), true);

// Verificar se os dados do carrinho foram recebidos corretamente
if (isset($post['array'])) {
    // Dados do carrinho
    $carrinho = $post['array']['produtos'];
    $total = $post['array']['total'];

    // Inserir dados na tabela 'pedido'
    $queryPedido = "INSERT INTO pedido (dataCriacao, quantItem, valorTotalPedido, fk_pessoa_idPessoa) VALUES (GETDATE(), ?, ?, 1)";
    $paramsPedido = array(count($carrinho), $total);
    $stmtPedido = sqlsrv_query($conexao, $queryPedido, $paramsPedido);

    // Verificar se a consulta de inserção do pedido foi bem-sucedida
    if ($stmtPedido === false) {
        echo "Erro ao inserir dados na tabela de pedido.";
        die(print_r(sqlsrv_errors(), true));
    }

    // Obter o ID do pedido inserido
    $idPedido = sqlsrv_fetch_array(sqlsrv_query($conexao, "SELECT SCOPE_IDENTITY()"));

    // Criar uma array para o pedido
    $pedidoArray = array(
        'idPedido' => $idPedido[0],
        'dataCriacao' => date("Y-m-d H:i:s"),
        'quantItem' => count($carrinho),
        'valorTotalPedido' => $total,
        'fk_pessoa_idPessoa' => 1 
);
print_r($pedidoArray);

  // Inserir dados na tabela 'item' para cada produto no carrinho
    foreach ($carrinho as $produto) {
        $queryItem = "INSERT INTO item (quantidade, fk_produto_idProduto, fk_pedido_idPedido) VALUES (?, ?, ?)";
        $paramsItem = array($produto['quantidade'], $produto['id'], $idPedido[0]);
        $stmtItem = sqlsrv_query($conexao, $queryItem, $paramsItem);

        // Verificar se a consulta de inserção do item foi bem-sucedida
        if ($stmtItem === false) {
            echo "Erro ao inserir dados na tabela de item.";
            die(print_r(sqlsrv_errors(), true));
        }
    }

    // Limpar o carrinho
    if (isset($_SESSION['carrinho'])) {
        unset($_SESSION['carrinho']);
    }

    // Fechar a conexão com o SQL Server
    sqlsrv_close($conexao);

    
    echo "Dados do carrinho não recebidos corretamente.";
} else {
    echo "Pedido finalizado com sucesso!";
    header("Location: lista_produto.php");
    exit();
   
}
?>
