// Variável para armazenar produtos no carrinho
const carrinho = [];
console.log('Valor do campo de pesquisa:', document.getElementById('formProduto').value);


function carregarProdutos() {
    // Limpa o conteúdo anterior
    const resultadosContainer = document.getElementById('resultados-pesquisa');
    resultadosContainer.innerHTML = '';

    // Faça uma requisição para o PHP para obter os produtos da pesquisa
    fetch('pesquisa_produto.php', {
        method: 'POST',
        body: new FormData(document.getElementById('pesquisa-form'))
    })
    .then(response => response.json())
    .then(produtos => {
        produtos.forEach(produto => {
            const produtoDiv = document.createElement('div');
            produtoDiv.className = 'produto';

            // Crie elementos HTML para exibir as informações do produto
            const imagemProduto = document.createElement('img');
            imagemProduto.src = produto.foto;
            imagemProduto.alt = produto.nomeProduto;

            const nomeProduto = document.createElement('h3');
            nomeProduto.textContent = produto.nomeProduto;

            const descricaoProduto = document.createElement('p');
            descricaoProduto.textContent = produto.descricao;

            const categoriaProduto = document.createElement('p');
            categoriaProduto.textContent = `Categoria: ${produto.nomeCategoria}`;

            const valorProduto = document.createElement('p');
            valorProduto.textContent = `Valor: R$ ${produto.valorProduto.toFixed(2).replace('.', ',')}`;

            const botaoAdicionar = document.createElement('button');
            botaoAdicionar.textContent = 'Adicionar ao Carrinho';
            botaoAdicionar.onclick = () => adicionarAoCarrinho(produto);

            // Adicione os elementos criados à div do produto
            produtoDiv.appendChild(imagemProduto);
            produtoDiv.appendChild(nomeProduto);
            produtoDiv.appendChild(descricaoProduto);
            produtoDiv.appendChild(categoriaProduto);
            produtoDiv.appendChild(valorProduto);
            produtoDiv.appendChild(botaoAdicionar);

            // Adicione a div do produto à área de resultados
            resultadosContainer.appendChild(produtoDiv);
        });
    })
    .catch(error => console.error('Erro ao buscar produtos:', error));
}

// Resto do código permanece o mesmo

// Chame a função para carregar os produtos quando a página carregar
window.onload = carregarProdutos;
