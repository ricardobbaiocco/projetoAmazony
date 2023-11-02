document.addEventListener("DOMContentLoaded", function() {
    // Formulário de cadastro de produto
    const formCadastroProduto = document.getElementById("form-cadastro-produto");
    const alertSuccessProduto = document.getElementById("alert-success-produto");
    const alertErrorProduto = document.getElementById("alert-error-produto");


        
    formCadastroProduto.addEventListener("submit", function(event) {
    event.preventDefault();

    // Valide os campos do cadastro de produto aqui (se necessário)

    // Se todos os campos obrigatórios foram preenchidos, envie o formulário
    if (!document.querySelector(".campo-erro")) {
        const formData = new FormData(formCadastroProduto);
        fetch("conclui_cadastro_produto.php", {
        method: "POST",
        body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            console.log("opa");
            if (data.success) {
            console.log("primeiro");
            // Exibir alerta de sucesso para o cadastro de produto
            alertSuccessProduto.style.display = "block";
            console.log("Aqui cheguei");
            alertErrorProduto.style.display = "none";
            // Redirecionar para outra página após um breve atraso
            setTimeout(function() {
                window.location.href = "lista_produto.php";
            }, 5000); // Redirecionar após 5 segundos
            } else {
            // Exibir alerta de erro para o cadastro de produto
            alertErrorProduto.style.display = "block";
            alertSuccessProduto.style.display = "none";
            }
        })
        .catch((error) => {
            console.error("Erro na requisição: ", error);
        });
    }
    })
});