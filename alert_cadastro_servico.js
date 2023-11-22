document.addEventListener("DOMContentLoaded", function() {
    // Formulário de cadastro de produto
    const formCadastroServico = document.getElementById("form-cadastro-servico");
    const alertSuccessServico = document.getElementById("alert-success-servico");
    const alertErrorServico = document.getElementById("alert-error-servico");


        
    formCadastroServico.addEventListener("submit", function(event) {
    event.preventDefault();


    // Se todos os campos obrigatórios foram preenchidos, envie o formulário
    if (!document.querySelector(".campo-erro")) {
        const formData = new FormData(formCadastroServico);
        fetch("conclui_cadastro_servico.php", {
        method: "POST",
        body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
            // Exibir alerta de sucesso para o cadastro de servico
            alertSuccessServico.style.display = "block";
            alertErrorServico.style.display = "none";
            // Redirecionar para outra página após um breve atraso
            setTimeout(function() {
                window.location.href = "tabela_servico.php";
            }, 3000); // Redirecionar após 3 segundos
            } else {
            // Exibir alerta de erro para o cadastro de servico
            alertErrorServico.style.display = "block";
            alertSuccessServico.style.display = "none";
            }
        })
        .catch((error) => {
            console.error("Erro na requisição: ", error);
        });
    }
    })
});