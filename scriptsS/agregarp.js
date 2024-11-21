document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('add-product-btn');
    const productForm = document.getElementById('product-form');
    const cancelBtn = document.getElementById('cancel-btn');

    // Toggle (alternar) el formulario al hacer clic en el ícono
    addProductBtn.addEventListener('click', function() {
        if (productForm.style.display === 'block') {
            productForm.style.display = 'none';  // Ocultar el formulario si ya está visible
        } else {
            productForm.style.display = 'block'; // Mostrar el formulario si no está visible
        }
    });

    // Ocultar el formulario al hacer clic en el botón cancelar
    cancelBtn.addEventListener('click', function() {
        productForm.style.display = 'none'; // Ocultar el formulario
    });
});
