document.addEventListener("DOMContentLoaded", function() {
    const addProductBtn = document.getElementById("add-product-btn");
    const formulario = document.querySelector(".product-form");

    // Mostrar formulario al hacer clic en el ícono de agregar producto
    addProductBtn.addEventListener("click", function(e) {
        e.stopPropagation(); // Evita que el clic se propague al documento
        formulario.style.display = "block"; // Muestra el formulario
    });

    // Cerrar formulario al hacer clic fuera de él
    document.addEventListener("click", function(event) {
        // Verifica si el clic fue fuera del formulario y fuera del botón
        if (!formulario.contains(event.target) && !addProductBtn.contains(event.target)) {
            formulario.style.display = "none"; // Ocultar el formulario
        }
    });

    // Si se hace clic en el botón de cancelar, cerrar el formulario
    const cancelBtn = document.getElementById("cancel-btn");
    if (cancelBtn) {
        cancelBtn.addEventListener("click", function() {
            formulario.style.display = "none"; // Cerrar el formulario
        });
    }
});
