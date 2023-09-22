document.addEventListener("DOMContentLoaded", function() {
    const formCadastro = document.getElementById("form-cadastro");
    const alertSuccess = document.getElementById("alert-success");
    const alertError = document.getElementById("alert-error");
  
    formCadastro.addEventListener("submit", function(event) {
      event.preventDefault();
  
      // Valide os campos aqui (como antes)
  
      // Se todos os campos obrigatórios foram preenchidos, envie o formulário
      if (!document.querySelector(".campo-erro")) {
        const formData = new FormData(formCadastro);
  
        fetch("cadastro_pessoa.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Exibir alerta de sucesso
              alertSuccess.style.display = "block";
              alertError.style.display = "none";
              // Redirecionar para outra página após um breve atraso
              setTimeout(function() {
                window.location.href = "cadastro_pessoa.html";
              }, 5000); // Redirecionar após 5 segundos
            } else {
              // Exibir alerta de erro
              alertError.style.display = "block";
              alertSuccess.style.display = "none";
            }
          })
          .catch((error) => {
            console.error("Erro na requisição: ", error);
          });
      }
    });
  });
