<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro Serviço</title>
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
    <br>
    <div class="container formularios">
    <div class="alert alert-success alert-narrow" id="alert-success-servico" style="display: none;">
            Serviço cadastrado com sucesso!
        </div>
        <div class="alert alert-danger alert-narrow" id="alert-error-servico" style="display: none;">
            Erro ao cadastrar serviço!
        </div>
        <br>
        <div id="alert-message" class="alert" style="display: none;"></div>
        <h2 align="center">Cadastro Serviço</h2>
        <br>
        <form method="POST" action="conclui_cadastro_servico.php" enctype="multipart/form-data" id="form-cadastro-servico">
            <div class="row justify-content-center">   
                <div class="form-group col-md-6">
                    <label for="nome">Nome do Serviço</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-6">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="form-group col-md-3">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" class="form-control col-md-6 mx-auto" required>
                        <?php require_once("busca_categoria.php"); ?>
                    </select>
                </div>
                
                <!-- Script do jQuery -->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <div class="form-group col-md-3">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                </div>
            </div>
            <br>
            <div class="row justify-content-center">  
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success tamanhoBotao">Salvar</button>
                    <a href="index.html"><button type="button" class="btn btn-secondary tamanhoBotao">Voltar</button></a>
                </div>
            </div>
        </form>
    </div>
    <script src="alert_cadastro_servico.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
