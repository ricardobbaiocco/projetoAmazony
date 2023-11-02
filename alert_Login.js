const formLogin = document.getElementById("form-login");
  const alertSuccessLogin = document.getElementById("alert-success-login");
  const alertErrorLogin = document.getElementById("alert-error-login");


  console.log("Cheguei no login com sucesso")

  formLogin.addEventListener("submit", function(event) {
    event.preventDefault();

    // Valide os campos do cadastro de cliente aqui (se necessário)

    // Se todos os campos obrigatórios foram preenchidos, envie o formulário
    if (document.querySelector("#usuario").value !== "" && document.querySelector("#senha").value !== "") {
      const FormDataLogin = new FormData(formLogin);
      console.log('Cheguei no login com sucesso')
      fetch("login_.php", {
        method: "POST",
        body: FormDataLogin,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Exibir alerta de sucesso para o cadastro de cliente
            alertSuccessLogin.style.display = "block";
            alertErrorLogin.style.display = "none";
            // Redirecionar para outra página após um breve atraso
            setTimeout(function() {
                window.location.href = "lista_produto.php";
            }, 1000); // Redirecionar após 1 segundos
          // Redirecionar após 5 segundos
          } else {
            // Exibir alerta de erro para o cadastro de cliente
            alertErrorLogin.style.display = "block";
            alertSuccessLogin.style.display = "none";
          }
        })
        .catch((error) => {
          console.error("Erro na requisição: ", error);
        });
    }
  });
