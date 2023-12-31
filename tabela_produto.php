<?php
// Inicie a sessão no início do script, antes de qualquer saída de conteúdo
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabela de Produtos</title>
    <link rel="icon" href="imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="banner">
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
    <div class="container formularios">
    <div class="alert alert-success alert-narrow" id="alert-success-produto" style="display: none;">
            Produto excluído com sucesso!
        </div>
        <div class="alert alert-danger alert-narrow" id="alert-error-produto" style="display: none;">
            Erro ao excluir produto.
        </div>
        <br>
        <div id="alert-message" class="alert" style="display: none;"></div>
        <h2>Tabela de Produtos</h2>
        <div class="row justify-content">
            <div class="form-group col-md-3">
                <a href="cadastro_produto.php" class="btn btn-success tamanhoBotao">Novo cadastro</a>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome do Produto</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                     

                    // Inclua a conexão com o banco de dados
                    require_once 'conexao.php';

                    // Consulta SQL para obter os produtos e suas categorias
                    $query = "SELECT produto.idProduto, produto.nomeProduto, produto.descricao, produto.valorProduto, categoria.nomeCategoria, produto.foto
                    FROM produto
                    JOIN categoria  ON produto.fk_categoria_idCategoria = categoria.idCategoria ORDER BY produto.nomeProduto";

                    $resultado = sqlsrv_query($conexao, $query);

                    // Verifica se a consulta foi bem-sucedida
                    if ($resultado) {
                        // Processar os resultados da consulta aqui
                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td><img src="data:image/*;base64,' . base64_encode($row['foto']) . '" class="produto-img" alt="Imagem do Produto"></td>';
                            echo '<td>' . $row['nomeProduto'] . '</td>';
                            echo '<td>' . $row['descricao'] . '</td>';
                            echo '<td>R$ ' . number_format($row['valorProduto'], 2, ',', '.') . '</td>';
                            echo '<td>' . $row['nomeCategoria'] . '</td>';
                            echo '<td>';
                            echo '<a href="editar_produto.php?id=' . $row['idProduto'] . '" class="btn btn-primary">Editar</a>';
                            echo '<a href="excluir_produto.php?id=' . $row['idProduto'] . '" class="btn btn-danger">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        // Feche a consulta
                        sqlsrv_free_stmt($resultado);

                        // Feche a conexão com o SQL Server
                        sqlsrv_close($conexao);
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Erro na consulta: ' . print_r(sqlsrv_errors(), true) . '</div>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
  
</script>
<script src="alert_excluir_produto.js"></script>
<script src="pagina_protegida.php"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
