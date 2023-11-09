<?php
// Inicie a sessão no início do script, antes de qualquer saída de conteúdo
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabela de Serviços</title>
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
                        <a class="nav-link active" href="pagina_funcionario.html">Página do Funcionário</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produto
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="cadastro_produto.php">Adicionar</a></li>
                            <li><a class="dropdown-item" href="tabela_produto.php">Alterar</a></li>
                            <li><a class="dropdown-item" href="lista_produto.php">Listar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Serviço
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="cadastro_servico.php">Adicionar</a></li>
                            <li><a class="dropdown-item" href="tabela_servico.php">Alterar</a></li>
                            <li><a class="dropdown-item" href="lista_servico.php">Listar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container formularios">
    <br>
        <h2>Tabela de Serviços</h2>
        <br> 
        <div class="row justify-content">
            <div class="form-group col-md-3">
                <a href="cadastro_servico.php" class="btn btn-success tamanhoBotao">Novo cadastro</a>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome do Serviço</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Inclua a conexão com o banco de dados
                    require_once 'conexao.php';

                    // Consulta SQL para obter os produtos e suas categorias
                    $query = "SELECT servico.idServico, servico.nomeServico, servico.descricao, categoria.nomeCategoria, servico.foto
                        FROM servico 
                        JOIN categoria  ON servico.fk_categoria_idCategoria = categoria.idCategoria";

                    $resultado = sqlsrv_query($conexao, $query);

                    // Verifica se a consulta foi bem-sucedida
                    if ($resultado) {
                        // Processar os resultados da consulta aqui
                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td><img src="data:image/*;base64,' . base64_encode($row['foto']) . '" class="produto-img" alt="Imagem do Serviço"></td>';
                            echo '<td>' . $row['nomeServico'] . '</td>';
                            echo '<td>' . $row['descricao'] . '</td>';
                            echo '<td>' . $row['nomeCategoria'] . '</td>';
                            echo '<td>';
                            echo '<a href="editar_servico.php?id=' . $row['idServico'] . '" class="btn btn-primary">Editar</a>';
                            echo '<a href="excluir_servico.php?id=' . $row['idServico'] . '" class="btn btn-danger">Excluir</a>';
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
    <script src="pagina_protegida.php"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
