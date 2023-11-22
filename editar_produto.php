<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Produto</title>
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
            Produto alterado com sucesso!
        </div>
        <div class="alert alert-danger alert-narrow" id="alert-error-produto" style="display: none;">
            Erro ao editar produto.
        </div>
        <br>
        <div id="alert-message" class="alert" style="display: none;"></div>
        <h2 align="center">Editar Produto</h2>
    <?php

    session_start();

    // Verifique se o usuário não está autenticado
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // O usuário não está autenticado, redirecione-o para a página de login
        header("Location: login.html");
        exit();
    }
    require_once('conexao.php');
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Faça a limpeza do ID
        $idProduto = $_GET['id'];

        // Consulta SQL para obter as informações do produto
        $query = "SELECT * FROM produto WHERE idProduto = ?";
        $params = array(&$idProduto);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado && $produto = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
    ?>
            <form method="POST" action="atualiza_produto.php" enctype="multipart/form-data" id="form-update-produto">
                <input type="hidden" name="id" value="<?php echo $idProduto; ?>">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $produto['nomeProduto']; ?>" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao" class="form-control" rows="4"><?php echo $produto['descricao']; ?></textarea>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-3">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" class="form-control col-md-6 mx-auto" required>
                            <?php
                            require_once('conexao.php');
                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                $idProduto = $_GET['id'];
                                $query = "SELECT * FROM produto WHERE idProduto = ?";
                                $params = array(&$idProduto);
                                $resultado = sqlsrv_query($conexao, $query, $params);

                                if ($resultado && $produto = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                    $queryCategoria = "SELECT idCategoria, nomeCategoria FROM categoria";
                                    $resultadoCategoria = sqlsrv_query($conexao, $queryCategoria);
                                    if ($resultadoCategoria) {
                                        while ($categoria = sqlsrv_fetch_array($resultadoCategoria, SQLSRV_FETCH_ASSOC)) {
                                            if ($produto['fk_categoria_idCategoria'] === $categoria['idCategoria']) {
                                                echo '<option value="' . $categoria['idCategoria'] . '" selected>' . $categoria['nomeCategoria'] . '</option>';
                                            } else {
                                                echo '<option value="' . $categoria['idCategoria'] . '">' . $categoria['nomeCategoria'] . '</option>';
                                            }
                                        }
                                    } else {
                                        echo "Erro na consulta de categorias: " . print_r(sqlsrv_errors(), true);
                                    }
                                } else {
                                    echo "Erro na consulta de produto: " . print_r(sqlsrv_errors(), true);
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="valor">Valor</label>
                        <input type="text" class="form-control" id="valor" name="valor" required value="<?php echo $produto['valorProduto']; ?>">
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="foto">Foto</label>
                        <img src="data:image/*;base64,<?php echo base64_encode($produto['foto']); ?>" class="produto-img" alt="Imagem do Produto">
                        <input type="file" class="form-control-file" id="foto" name="foto">
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-success tamanhoBotao">Salvar</button>
                        <a href="tabela_produto.php"><button type="button" class="btn btn-secondary tamanhoBotao">Voltar</button></a>
                    </div>
                </div>
            </form>
    <?php
        } else {
            echo '<div class="alert alert-danger" role="alert">Produto não encontrado</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">ID do produto não fornecido</div>';
    }
    ?>
</div>

    <!--<script src="busca_categoria.js"></script>-->
   <script src="alert_update_produto.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> 
  
</body>
</html>
