<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem de Produtos</title>
    <link rel="icon" href="imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .produto-card {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            text-align: center;
            width: 300px;
            height: 350px;
            display: inline-block;
        }

        .produto-img {
            max-width: 100%;
            height: auto;
        }

        .produto-nome {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .produto-descricao {
            font-size: 0.9rem;
        }

        .produto-preco {
            font-size: 1.1rem;
            color: #e74c3c;
            font-weight: bold;
        }

        .quantidade-input {
            width: 50px;
        }

        .adicionar-btn {
            width: 100px;
        }

        .carrinho-item {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="banner">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <div class="logo">
                <a href="index.html">Amazony Info</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lista_produto.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lista_servico.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class "nav-item">
                        <a class="nav-link" href="quemsomos.html">Quem Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container formularios">
        <form method="POST" action="lista_produto.php" id="pesquisa-form" name="pesquisa-form">
            <div class="row justify-content-center">
                <div class="form-group col-md-4">
                    <label for "produto_nome">Nome do Produto</label>
                    <input type="text" class="form-control" id="formProduto" name="formProduto">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary tamanhoBotao">Pesquisar</button>
                </div>
            </div>
        </form>
        <br>
        <h2>Listagem de Produtos</h2>

        <!-- Listagem de Produtos como Cards -->
        <div class="row" id="listaProdutos">
            <?php
            // Inclua a conexão com o banco de dados
            require_once 'conexao.php';

            // Inicialize a variável de pesquisa
            $pesquisa = '';

            // Inicialize a variável $params como um array vazio
            $params = array();

            // Verifique se o formulário de pesquisa foi enviado
            if (isset($_POST['formProduto'])) {
                // Limpe a entrada do usuário
                $pesquisa = trim($_POST['formProduto']);
            }

            // Exemplo de consulta SQL com JOIN entre as tabelas 'produto' e 'categoria'
            $query = "SELECT p.idProduto, p.nomeProduto, p.descricao, p.valorProduto, c.nomeCategoria, p.foto
            FROM produto p
            JOIN categoria c ON p.fk_categoria_idCategoria = c.idCategoria";

            // Aplica o filtro se o campo de pesquisa não estiver vazio
            if (!empty($pesquisa)) {
                $query .= " WHERE p.nomeProduto LIKE '%' + ? + '%'";
                // Adicione $pesquisa ao array $params
                $params[] = &$pesquisa;
            }

            // Executa a consulta SQL
            $resultado = sqlsrv_query($conexao, $query, $params);

            // Verifica se a consulta foi bem-sucedida
            if ($resultado) {
                // Processar os resultados da consulta aqui
                while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                    echo '<div class="col-md-3">';
                    echo '<div class="produto-card">';
                    echo '<img src="data:image/*;base64,' . base64_encode($row['foto']) . '" class="produto-img" alt="Imagem do Produto">';
                    echo '<div class="produto-nome">' . $row['nomeProduto'] . '</div>';
                    echo '<div class="produto-descricao">' . $row['descricao'] . '</div>';
                    echo '<div class="produto-preco">R$ ' . number_format($row['valorProduto'], 2, ',', '.') . '</div>';
            
                    // Adicione o campo de entrada e o botão "Adicionar ao Carrinho" em linha
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    echo '<input type="number" id="quantidade-' . $row['idProduto'] . '" placeholder="Qtd." min="1" class="mr-2 quantidade-input form-control" style="width: 70px;">';
                    echo '<button onclick="adicionarAoCarrinho(' . $row['idProduto'] . ', \'' . $row['nomeProduto'] . '\', document.getElementById(\'quantidade-' . $row['idProduto'] . '\').value, ' . $row['valorProduto'] . ')" class="btn btn-primary adicionar-btn">Adicionar</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';    
                }

                // Feche a consulta
                sqlsrv_free_stmt($resultado);

                // Feche a conexão com o SQL Server
                sqlsrv_close($conexao);
            } else {
                echo '<div class="alert alert-danger" role="alert">Erro na consulta: ' . print_r(sqlsrv_errors(), true) . '</div>';
            }
            ?>
        </div>
    </div>
    <script src="carrinho.js"></script>
</body>
</html>
