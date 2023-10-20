// Array para armazenar os produtos no carrinho
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];


// Função para exibir os produtos no carrinho
function exibirCarrinho() {
    const carrinhoLista = document.getElementById('carrinho-lista');
    const totalCarrinhoElement = document.getElementById('total-carrinho');
    
    if (carrinhoLista && totalCarrinhoElement) {
        carrinhoLista.innerHTML = ''; // Limpar a lista
        let total = 0;

        carrinho.forEach((produto, index) => {
            const row = carrinhoLista.insertRow(-1); // Adiciona uma nova linha ao final da tabela

            const cellNome = row.insertCell(0);
            const cellQuantidade = row.insertCell(1);
            const cellPreco = row.insertCell(2);
            const cellAcoes = row.insertCell(3);
            
            if (produto && produto.nome) {
                cellNome.textContent = produto.nome;
            } else {
                cellNome.textContent = "Nome do produto indisponível";
            }
           

            const inputQuantidade = document.createElement('input');
            inputQuantidade.type = 'number';
            inputQuantidade.value = produto.quantidade;
            inputQuantidade.addEventListener('change', (event) => atualizarQuantidade(produto, event.target.value));
            cellQuantidade.appendChild(inputQuantidade);
           
            cellPreco.textContent = `R$ ${formatarNumero(produto.preco)}`;

            const btnExcluir = document.createElement('button');
            btnExcluir.textContent = 'Excluir';
            btnExcluir.addEventListener('click', () => excluirItem(index)); // Passando o índice como parâmetro
            cellAcoes.appendChild(btnExcluir);
            
            total += produto.preco * produto.quantidade; // Corrigido para calcular o total corretamente
        });

        totalCarrinhoElement.textContent = `R$ ${formatarNumero(total)}`;
    }
}

// Função para formatar o número com separador de milhar
function formatarNumero(numero) {
    return numero.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
}

// Função para excluir um item do carrinho
function excluirItem(index) {
    console.log('Excluindo item...');
    if (index > -1) {
        carrinho.splice(index, 1);
    }
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    exibirCarrinho();
}

// Função para atualizar a quantidade do produto no carrinho
function atualizarQuantidade(produto, novaQuantidade) {
    console.log('Atualizando quantidade...');
    const quantidade = parseInt(novaQuantidade);
    if (!quantidade || quantidade <= 0) {
        alert('Por favor, insira uma quantidade válida.');
        return;
    }
    produto.quantidade = quantidade;
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    exibirCarrinho();
}


// Função para adicionar produtos ao carrinho
function adicionarAoCarrinho(id, nome, quantidade, preco) {
    console.log("Adicionando ao carrinho...");
    console.log("ID do produto:", id);
    console.log("Nome do produto:", nome);
    console.log("Quantidade:", quantidade);
    console.log("Preço:", preco);
    const inputId = 'quantidade-' + id;
    const quantidadeInput = document.getElementById(inputId);

    if (!quantidadeInput) {
        console.error("Elemento de entrada não encontrado");
        return;
    }

    const quant = parseInt(quantidadeInput.value);

    if (!quant || quant <= 0) {
        alert('Por favor, insira uma quantidade válida.');
        return;
    }

    const carrinhoItem = JSON.parse(localStorage.getItem('carrinho')) || [];
    console.log("Carrinho atual:", carrinhoItem);

    const produto = carrinhoItem.find((p) => p.id === id);
    if (produto) {
        produto.quantidade += quant;
    } else {
        carrinhoItem.push({ id, nome, quantidade: quant, preco });
    }

    console.log("Carrinho atualizado:", carrinhoItem);

    // Armazenar o carrinho no armazenamento local
    localStorage.setItem('carrinho', JSON.stringify(carrinhoItem));

    // Atualizar e exibir o carrinho
    exibirCarrinho();

    // Redirecionar para a página de carrinho após a conclusão das operações
    
        window.location.href = 'carrinho_compras.html';
    
}



// Obter a lista de itens do carrinho
const carrinhoLista = document.getElementById('carrinho-lista');
const totalCarrinho = document.getElementById('total-carrinho').innerText;

// Criar um objeto com os dados do carrinho
const dadosCarrinho = {
    items: carrinhoLista.innerHTML,
    total: totalCarrinho
};



// Enviar os dados para o PHP usando AJAX
const xhr = new XMLHttpRequest();
xhr.open('POST', 'finalizar_pedido.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText); // Resposta do servidor
    }
};

// Converter os dados para JSON antes de enviar
const dadosJSON = JSON.stringify(dadosCarrinho);
xhr.send(dadosJSON);

// Inicializar a exibição do carrinho
exibirCarrinho();
