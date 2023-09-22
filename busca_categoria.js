document.addEventListener("DOMContentLoaded", function() {
    const categoriaSelect = document.getElementById("categoria");
  
    // Realizar uma requisição AJAX para obter as categorias do banco de dados
    fetch("listar_categorias.php")
      .then(response => response.json())
      .then(data => {
        // Preencher o select com as categorias
        data.forEach(categoria => {
          const option = document.createElement("option");
          option.value = categoria.idCategoria; // Defina o valor conforme necessário
          option.text = categoria.nomeCategoria;
          categoriaSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Erro na requisição: ", error);
      });
  });
  