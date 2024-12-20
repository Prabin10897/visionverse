// script.js
document.addEventListener("DOMContentLoaded", () => {
    // Quantity control
    const decreaseBtn = document.getElementById("decrease");
    const increaseBtn = document.getElementById("increase");
    const quantityInput = document.getElementById("quantity");

    decreaseBtn.addEventListener("click", () => {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });

    increaseBtn.addEventListener("click", () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });

    // Toggle details sections
    document.querySelectorAll(".details-toggle").forEach((toggle) => {
        toggle.addEventListener("click", () => {
            const content = toggle.querySelector(".details-content");
            const icon = toggle.querySelector("i");
            content.style.display = content.style.display === "block" ? "none" : "block";
            icon.classList.toggle("fa-plus");
            icon.classList.toggle("fa-minus");
        });
    });
});
