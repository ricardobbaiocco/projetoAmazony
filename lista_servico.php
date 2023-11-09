<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem de Serviços</title>
    <link rel="icon" href="imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .servico-card {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            text-align: center;
            width: 300px;
            height: 350px;
            display: inline-block;
        }

        .servico-img {
            max-width: 100%;
            height: auto;
        }

        .servico-nome {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .servico-descricao {
            font-size: 0.9rem;
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
                </ul>
            </div>
        </div>
    </nav>
    <div class="container formularios">
        <form method="POST" action="lista_servico.php" id="pesquisa-form" name="pesquisa-form">
            <div class="row justify-content-center">
                <div class="form-group col-md-4">
                    <label for "servico_nome">Nome do Serviço</label>
                    <input type="text" class="form-control" id="formServico" name="formServico">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary tamanhoBotao">Pesquisar</button>
                </div>
            </div>
        </form>
        <br>
        <h2>Listagem de Serviços</h2>

        <!-- Listagem de Produtos como Cards -->
        <div class="row" id="listaServicos">
            <?php
            // Inclua a conexão com o banco de dados
            require_once 'conexao.php';

            // Inicialize a variável de pesquisa
            $pesquisa = '';

            // Inicialize a variável $params como um array vazio
            $params = array();

            // Verifique se o formulário de pesquisa foi enviado
            if (isset($_POST['formServico'])) {
                // Limpe a entrada do usuário
                $pesquisa = trim($_POST['formServico']);
            }

            // Exemplo de consulta SQL com JOIN entre as tabelas 'produto' e 'categoria'
            $query = "SELECT servico.idServico, servico.nomeServico, servico.descricao, categoria.nomeCategoria, servico.foto
            FROM servico 
            JOIN categoria  ON servico.fk_categoria_idCategoria = categoria.idCategoria";

            // Aplica o filtro se o campo de pesquisa não estiver vazio
            if (!empty($pesquisa)) {
                $query .= " WHERE servico.nomeServico LIKE '%' + ? + '%'";
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
                    echo '<div class="servico-card">';
                    echo '<img src="data:image/*;base64,' . base64_encode($row['foto']) . '" class="servico-img" alt="Imagem do Servico">';
                    echo '<div class="servico-nome">' . $row['nomeServico'] . '</div>';
                    echo '<div class="servico-descricao">' . $row['descricao'] . '</div>';
                   
                    // Adicione o campo de entrada e o botão "Adicionar ao Carrinho" em linha
                    echo '<div class="d-flex align-items-center justify-content-center">';
                    echo '<button onclick="adicionarAoCarrinho(' . $row['idServico'] . ', \'' . $row['nomeServico'] . ')" class="btn btn-primary adicionar-btn">Adicionar</button>';
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
    <script src="carrinho_servico.js"></script>
</body>
</html>
