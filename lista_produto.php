<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem de Produtos</title>
    <link rel="icon" href="imagens/logo.png" type="image/png">
    <!-- Adicione os estilos do Bootstrap 5 (remova a versão antiga) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Adicione o seu estilo.css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div style="position: fixed; bottom: 25px; right: 25px; z-index: 99999; text-align: center;">
    <a href="https://api.whatsapp.com/send?l=pt&amp;phone=5554991488164">
        <img src="https://i.imgur.com/ryESuZ5.png" style="height: 64px;" data-selector="img">
    </a>
    <div style="margin-top: 5px;">Dúvidas?</div>
</div>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Amazony Info</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($paginaAtual == 'index.html') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.html">Página Inicial</a>
                </li>
                <li class="nav-item <?php echo ($paginaAtual == 'lista_produto.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="lista_produto.php">Produtos</a>
                </li>
                <li class="nav-item <?php echo ($paginaAtual == 'lista_servico.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="lista_servico.php">Serviços</a>
                </li>
                <li class="nav-item <?php echo ($paginaAtual == 'login.html') ? 'active' : ''; ?>">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
                <li class="nav-item <?php echo ($paginaAtual == 'quemsomos.html') ? 'active' : ''; ?>">
                    <a class="nav-link" href="quemsomos.html">Quem Somos</a>
                </li>
                <li class="nav-item <?php echo ($paginaAtual == 'logout.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="banner">
        <h1 class="display-4">Descubra Nossos Produtos Exclusivos</h1>
        <p class="lead">Encontre as melhores ofertas em tecnologia.</p>
    </div>

    <div class="container">
        <form method="POST" action="lista_produto.php" class="pesquisa-form">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <label for="formProduto" class="form-label"></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="formProduto" name="formProduto">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
            </div>
        </form>

        <h2 class="mb-4">Nossos Produtos</h2>

        <!-- Listagem de Produtos como Cards -->
        <div class="row" id="listaProdutos">
            <?php
            // Inclua a conexão com o banco de dados
            require_once 'conexao.php';

            // Inicialize a variável de pesquisa
            $pesquisa = '';

            // Inicialize a variável $params como um array vazio
            $params = array();

            // Exemplo de consulta SQL com JOIN entre as tabelas 'produto' e 'categoria'
            $query = "SELECT produto.idProduto, produto.nomeProduto, produto.descricao, produto.valorProduto, categoria.nomeCategoria, produto.foto
            FROM produto 
            JOIN categoria  ON produto.fk_categoria_idCategoria = categoria.idCategoria";

            // Verifique se o formulário de pesquisa foi enviado
            if (isset($_POST['formProduto'])) {
                // Limpe a entrada do usuário
                $pesquisa = trim($_POST['formProduto']);
            }
                // Inicialize a variável $params como um array vazio
                $params = array();

                // Aplica o filtro se o campo de pesquisa não estiver vazio
                if (!empty($pesquisa)) {
                    $query .= " WHERE produto.nomeProduto LIKE '%' + ? + '%'";
                    // Adicione $pesquisa ao array $params
                    $params[] = &$pesquisa;
                }
                // Adiciona a cláusula ORDER BY para ordenar pelo nome do produto
                $query .= " ORDER BY produto.nomeProduto";

            // Executa a consulta SQL
            $resultado = sqlsrv_query($conexao, $query, $params);

            // Verifica se a consulta foi bem-sucedida
            if ($resultado) {
                 // Verifica se foram encontrados registros
                 if (sqlsrv_has_rows($resultado)) {
                    // Processar os resultados da consulta aqui
                    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                        echo '<div class="col-md-4 produto-card">';
                        echo '<div class="card mb-4 shadow-sm">';
                        echo '<div class="produto-img-container">';
                        echo '<img src="data:image/*;base64,' . base64_encode($row['foto']) . '" class="produto-img card-img-top" alt="Imagem do Produto">';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title text-center">' . $row['nomeProduto'] . '</h5>';
                        echo '<p class="card-text text-center">' . $row['descricao'] . '</p>';
                        echo '<p class="produto-preco text-center">R$ ' . number_format($row['valorProduto'], 2, ',', '.') . '</p>';
                        echo '<div class="d-flex justify-content-center">';
                        echo '<input type="number" id="quantidade-' . $row['idProduto'] . '" placeholder="Qtd." min="1" class="mr-2 quantidade-input form-control" style="width: 70px;">';
                        echo '<div class="btn-group">';
                        echo '<button onclick="adicionarAoCarrinho(' . $row['idProduto'] . ', \'' . $row['nomeProduto'] . '\', document.getElementById(\'quantidade-' . $row['idProduto'] . '\').value, ' . $row['valorProduto'] . ')" class="btn btn-success">Adicionar ao carrinho</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }else {
                    // Exibe uma mensagem caso nenhum serviço seja encontrado
                    echo '<div class="alert alert-info" role="alert">Nenhum produto encontrado.</div>';
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
    <footer class="bg-dark text-center py-10 rounded-top p-3">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2023 Amazony Info. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#">Termos de Serviço</a></li>
                        <li class="list-inline-item"><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="carrinho.js"></script>
    <!-- Adicione os scripts do Bootstrap 5 (remova a versão antiga) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
