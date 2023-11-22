document.addEventListener("DOMContentLoaded", function() {
  // Formulário de cadastro de cliente
  const formCadastroCliente = document.getElementById("form-cadastro");
  const alertSuccessCliente = document.getElementById("alert-success");
  const alertErrorCliente = document.getElementById("alert-error");

  formCadastroCliente.addEventListener("submit", function(event) {
    event.preventDefault();

    // Valide os campos do cadastro de cliente aqui (se necessário)

    // Se todos os campos obrigatórios foram preenchidos, envie o formulário
    if (!document.querySelector(".campo-erro")) {
      const formData = new FormData(formCadastroCliente);

      fetch("cadastro_pessoa.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Exibir alerta de sucesso para o cadastro de cliente
            alertSuccessCliente.style.display = "block";
            alertErrorCliente.style.display = "none";
            // Redirecionar para outra página após um breve atraso
            setTimeout(function() {
              window.location.href = "cadastro_pessoa.html";
            }, 3000); // Redirecionar após 5 segundos
          } else {
            // Exibir alerta de erro para o cadastro de cliente
            alertErrorCliente.style.display = "block";
            alertSuccessCliente.style.display = "none";
          }
        })
        .catch((error) => {
          console.error("Erro na requisição: ", error);
        });
    }
  });
});

