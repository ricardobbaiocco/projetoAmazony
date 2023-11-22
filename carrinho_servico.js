// Array para armazenar os produtos no carrinho
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];


// Função para exibir os produtos no carrinho
function exibirCarrinho() {
    console.log('Exibindo carrinho...');
    const carrinhoLista = document.getElementById('carrinho-lista');
    
    if (carrinhoLista && totalCarrinhoElement) {
        carrinhoLista.innerHTML = ''; // Limpar a lista
        carrinho.forEach((servico, index) => {
            const row = carrinhoLista.insertRow(-1); // Adiciona uma nova linha ao final da tabela

            const cellNome = row.insertCell(0);
            const cellAcoes = row.insertCell(3);
            if (servico && servico.nome) {
                cellNome.textContent = servico.nome;
            } else {
                cellNome.textContent = "Nome do serviço indisponível";
            }

            const btnExcluir = document.createElement('button');
            btnExcluir.textContent = 'Excluir';
            btnExcluir.addEventListener('click', () => excluirItem(index)); // Passando o índice como parâmetro
            cellAcoes.appendChild(btnExcluir);
        });

    }
}

function excluirItem(index) {
    console.log('Excluindo item...');
    if (index > -1) {
        carrinho.splice(index, 1);
    }
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    exibirCarrinho();
}


// Função para adicionar produtos ao carrinho
function adicionarAoCarrinho(id, nome) {
    console.log("Adicionando ao carrinho...");
    console.log("ID do serviço:", id);
    console.log("Nome do serviço:", nome);


    

    const carrinhoItem = JSON.parse(localStorage.getItem('carrinho')) || [];
    console.log("Carrinho atual:", carrinhoItem);

    const servico = carrinhoItem.find((s) => s.id === id);

    console.log("Carrinho atualizado:", carrinhoItem);

    // Armazenar o carrinho no armazenamento local
    localStorage.setItem('carrinho', JSON.stringify(carrinhoItem));

    // Atualizar e exibir o carrinho
    exibirCarrinho();

    // Redirecionar para a página de carrinho após a conclusão das operações
    
        window.location.href = 'carrinho_servico.html';
    
}



// Obter a lista de itens do carrinho
const carrinhoLista = document.getElementById('carrinho-lista');

// Criar um objeto com os dados do carrinho
const dadosCarrinho = {
    items: carrinhoLista.innerHTML,
};


// Enviar os dados para o PHP usando AJAX
const xhr = new XMLHttpRequest();
xhr.open('POST', 'finalizar_pedido_servico.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText); // Resposta do servidor
    }
};

// Converter os dados para JSON antes de enviar
const dadosJSON = JSON.stringify(dadosCarrinho);
xhr.send(dadosJSON);

