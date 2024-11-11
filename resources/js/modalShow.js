document.addEventListener("DOMContentLoaded", function () {
    const finishButton = document.querySelector("#finishButton");
    const modal = document.getElementById("finishOrderModal");
    const modalContent = document.getElementById("modalContent");
    const form = document.getElementById("form-description");

    finishButton.addEventListener("click", function (event) {
        event.preventDefault();
        modal.classList.remove("hidden");
        modal.classList.remove("opacity-0");

        setTimeout(() => {
            modalContent.classList.remove("scale-75", "opacity-0");
            modalContent.classList.add("scale-100", "opacity-100");
        }, 10);

        setTimeout(() => {
            form.submit();
        }, 2000);
    });
});
