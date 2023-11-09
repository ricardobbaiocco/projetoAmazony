document.addEventListener("DOMContentLoaded", function() {
    const alertSuccess = document.querySelector("#alert-success-produto");
    const alertDanger = document.querySelector("#alert-error-produto");
    
    if (alertSuccess) {
        showAlert(alertSuccess.innerText, true);
    } else if (alertDanger) {
        showAlert(alertDanger.innerText, false);
    }
});

function showAlert(message, isSuccess) {
    const alertContainer = document.createElement("div");
    alertContainer.classList.add("alert", isSuccess ? "alert-success" : "alert-danger");
    alertContainer.textContent = message;
    document.querySelector(".container").insertBefore(alertContainer, document.querySelector(".table-responsive"));

    setTimeout(function() {
        alertContainer.style.display = "none";
    }, 3000);
}
