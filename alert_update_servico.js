
document.addEventListener("DOMContentLoaded", function() {
    const formUpdateServico = document.getElementById("form-update-servico");
    const alertSuccessServico = document.getElementById("alert-success-servico");
    const alertErrorServico = document.getElementById("alert-error-servico");

    formUpdateServico.addEventListener("submit", function(event) {
        event.preventDefault();

        if (!document.querySelector(".campo-erro")) {
            const formData = new FormData(formUpdateServico);
            fetch("atualiza_servico.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData.success) {
                        alertSuccessServico.textContent = jsonData.message;
                        alertSuccessServico.style.display = "block";
                        alertErrorServico.style.display = "none";
                        setTimeout(function() {
                            
                           
            window.location.href = "tabela_servico.php";
                        }, 3000);
                    } else {
                        alertErrorServico.textContent = jsonData.message;
                        alertErrorServico.
                       
            style.display = "block";
                        alertSuccessServico.style.display = "none";
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
