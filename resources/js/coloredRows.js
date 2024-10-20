document.addEventListener("DOMContentLoaded", function () {
let selectedRow = null;


document.querySelectorAll("td").forEach((el) => {
    el.addEventListener("click", function (event) {
        const tr = event.target.closest("tr");
        const input = tr.querySelector('input[type="checkbox"]');
        if (selectedRow === tr) {
            input.checked = false;
            tr.classList.remove("bg-blue-200");
            tr.classList.remove("dark:bg-blue-500");
            selectedRow = null;
        } else {
            if (selectedRow) {
                const inputSelectedRow = selectedRow.querySelector(
                    'input[type="checkbox"]'
                );
                inputSelectedRow.checked = false;
                selectedRow.classList.remove("bg-blue-200");
                selectedRow.classList.remove("dark:bg-blue-500");
            }
            const id = tr.querySelector("td:nth-child(1)").textContent.trim();
            console.log(window.location.href = `/admin-secure/users/${id}/edit`)           
            input.checked = true;
            tr.classList.add("bg-blue-200");
            tr.classList.add("dark:bg-blue-500");
            selectedRow = tr;
        }
    });
});
})
