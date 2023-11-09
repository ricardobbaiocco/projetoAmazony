const formLogin = document.getElementById("form-login");
const alertSuccessLogin = document.getElementById("alert-success-login");
const alertErrorLogin = document.getElementById("alert-error-login");

formLogin.addEventListener("submit", function(event) {
    event.preventDefault();

    // Valide os campos do cadastro de cliente aqui (se necessário)

    // Se todos os campos obrigatórios foram preenchidos, envie o formulário
    if (document.querySelector("#usuario").value !== "" && document.querySelector("#senha").value !== "") {
        const FormDataLogin = new FormData(formLogin);
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
                // Redirecionar com base na resposta do servidor
                if (data.redirect) {
                    if (data.redirect === 'index.html') {
                        window.location.href = 'index.html'; // Redirecionar para a página 1
                    } else if (data.redirect === 'pagina_funcionario.html') {
                        window.location.href = 'pagina_funcionario.html'; // Redirecionar para a página 2
                    }
                }
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
