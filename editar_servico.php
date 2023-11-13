<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Serviço</title>
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
    <div class="alert alert-success alert-narrow" id="alert-success-servico" style="display: none;">
        Serviço alterado com sucesso!
    </div>
    <div class="alert alert-danger alert-narrow" id="alert-error-servico" style="display: none;">
        Erro ao editar serviço!
    </div>
        <br>
        <div id="alert-message" class="alert" style="display: none;"></div>
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
        $idServico = $_GET['id'];

        // Consulta SQL para obter as informações do servico
        $query = "SELECT * FROM servico WHERE idServico = ?";
        $params = array(&$idServico);
        $resultado = sqlsrv_query($conexao, $query, $params);

        if ($resultado && $servico = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
    ?>
            <form method="POST" action="atualiza_servico.php" enctype="multipart/form-data" id="form-update-servico">
                <input type="hidden" name="id" value="<?php echo $idServico; ?>">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome do Servico</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $servico['nomeServico']; ?>" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao" class="form-control" rows="4"><?php echo $servico['descricao']; ?></textarea>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" class="form-control col-md-6 mx-auto" required>
                            <?php
                            require_once('conexao.php');
                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                $idProduto = $_GET['id'];
                                $query = "SELECT * FROM servico WHERE idServico = ?";
                                $params = array(&$idServico);
                                $resultado = sqlsrv_query($conexao, $query, $params);

                                if ($resultado && $servico = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                    $queryCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
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
                                    echo "Erro na consulta de serviço: " . print_r(sqlsrv_errors(), true);
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <label for="foto">Foto</label>
                        <img src="data:image/*;base64,<?php echo base64_encode($servico['foto']); ?>" class="produto-img" alt="Imagem do Serviço">
                        <input type="file" class="form-control-file" id="foto" name="foto">
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-success tamanhoBotao">Salvar</button>
                        <a href="tabela_servico.php"><button type="button" class="btn btn-secondary tamanhoBotao">Voltar</button></a>
                    </div>
                </div>
            </form>
    <?php
        } else {
            echo '<div class="alert alert-danger" role="alert">Serviço não encontrado</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">ID do serviço não fornecido</div>';
    }
    ?>
</div>

    <!--<script src="busca_categoria.js"></script>-->
    <script src="alert_update_servico.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> 
   
</body>
</html>
