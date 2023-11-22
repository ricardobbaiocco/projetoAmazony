
document.addEventListener("DOMContentLoaded", function() {
    const formUpdateProduto = document.getElementById("form-update-produto");
    const alertSuccessProduto = document.getElementById("alert-success-produto");
    const alertErrorProduto = document.getElementById("alert-error-produto");

    formUpdateProduto.addEventListener("submit", function(event) {
        event.preventDefault();

        if (!document.querySelector(".campo-erro")) {
            const formData = new FormData(formUpdateProduto);
            fetch("atualiza_produto.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.success) {
                        alertSuccessProduto.textContent = jsonData.message;
                        alertSuccessProduto.style.display = "block";
                        alertErrorProduto.style.display = "none";
                        setTimeout(function() {
                            
                           
            window.location.href = "tabela_produto.php";
                        }, 3000);
                    } else {
                        alertErrorProduto.textContent = jsonData.message;
                        alertErrorProduto.
                       
            style.display = "block";
                        alertSuccessProduto.style.display = "none";
                    }
                } catch (error) {
                    console.error("Erro ao analisar JSON: ", error);
                }
            })
            .catch(error => {
                console.error("Erro na requisição: ", error);
            });
        }
    });
});
