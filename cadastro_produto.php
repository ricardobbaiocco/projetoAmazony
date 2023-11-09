<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro Produto</title>
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
        <div class="alert alert-success alert-narrow" id="alert-success-produto" style="display: none;">
            Produto cadastrado com sucesso!
        </div>
        <div class="alert alert-danger alert-narrow" id="alert-error-produto" style="display: none;">
            Erro ao cadastrar produto.
        </div>
        <br>
        <div id="alert-message" class="alert" style="display: none;"></div>
        <h2 align="center">Cadastro Produto</h2>
        <br>
        <form method="POST" action="conclui_cadastro_produto.php" enctype="multipart/form-data" id="form-cadastro-produto">
            <div class="row justify-content-center">   
                <div class="form-group col-md-6">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-6">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4"></textarea>
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
                <div class="form-group col-md-3">
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" required>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="form-group col-md-6">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                </div>
            </div>
            <div class="row justify-content-center">  
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success tamanhoBotao">Salvar</button>
                    <a href="index.html"><button type="button" class="btn btn-secondary tamanhoBotao">Voltar</button></a>
                </div>
            </div>
        </form>
    </div>
    <!--<script src="busca_categoria.js"></script>-->
    
    <script src="alert_cadastro_prod.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> 
    <script src="alert_cadastro.js"></script>
</body>
</html>
