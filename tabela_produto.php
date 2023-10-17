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
                        <a class="nav-link" href="cadastro_servico.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quem Somos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container formularios">
    <br>
        <h2>Tabela de Produtos</h2>
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
                    $query = "SELECT p.idProduto, p.nomeProduto, p.descricao, p.valorProduto, c.nomeCategoria, p.foto
                        FROM produto p
                        JOIN categoria c ON p.fk_categoria_idCategoria = c.idCategoria";

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
    
</body>
</html>