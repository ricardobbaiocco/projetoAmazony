<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['carrinho'])) {
    if (isset($_POST['nome']) && !empty(trim($_POST['nome']))) {
        // Recebendo os dados do carrinho
        $carrinho = json_decode($_POST['carrinho'], true);

        // Dados do carrinho
        $produtos = $carrinho['produtos'] ?? [];
        $total = $carrinho['total'] ?? 0;

        // Inserir dados na tabela 'pedido' e 'item'
        // ... (seu código de inserção na tabela)

        // Preparar os dados para enviar via WhatsApp
        $cpf = $_POST['nome']; // CPF do cliente
        $mensagem = "Olá, segue o resumo do seu pedido:\n\n";
        $mensagem .= "CPF: $cpf\n";
        $mensagem .= "Total: R$ $total\n\n";
        $mensagem .= "Itens:\n";

        // Adicionando detalhes de cada produto no carrinho à mensagem do WhatsApp
        foreach ($produtos as $produto) {
            $nomeProduto = $produto['nome'];
            $quantidade = $produto['quantidade'];
            $preco = $produto['preco'];

            // Concatenando detalhes de cada produto à mensagem
            $mensagem .= "- $nomeProduto | Quantidade: $quantidade | Preço unitário: R$ $preco\n";
        }

        // Agora você pode usar a variável $mensagem para enviar via WhatsApp
        // Você precisará de uma API ou um serviço para enviar mensagens pelo WhatsApp

        // Exemplo de como você poderia enviar a mensagem (isso pode variar dependendo da API ou serviço usado)
        // Aqui está um exemplo fictício usando a função mail() do PHP
        $to = 'seu_whatsapp@provedor.com'; // Substitua pelo seu número de WhatsApp
        $subject = 'Resumo do pedido';
        $headers = "From: seu_email@provedor.com";
        mail($to, $subject, $mensagem, $headers);

        echo "Pedido finalizado com sucesso!";

        // Redirecionar ou realizar outras ações após o pedido ser finalizado
    } else {
        echo "O campo CPF não foi preenchido ou está vazio.";
    }
} else {
    echo "Dados do carrinho não recebidos corretamente.";
}
?>
