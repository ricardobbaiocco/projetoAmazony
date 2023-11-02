
    document.addEventListener("DOMContentLoaded", function() {
        const alertSuccess = document.querySelector(".alert.alert-success");
        const alertDanger = document.querySelector(".alert.alert-danger");
        
        if (alertSuccess) {
            alert(alertSuccess.innerText);
            setTimeout(function(){ window.location = "tabela_produto.php"; });
        } else if (alertDanger) {
            alert(alertDanger.innerText);
        }
    });

