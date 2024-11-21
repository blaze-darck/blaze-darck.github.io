function showCategory(categoryId) {
    // Ocultar todas las categorías
    const categories = document.querySelectorAll('.category');
    categories.forEach(function(category) {
        category.style.display = 'none';
    });

    // Mostrar la categoría seleccionada
    const activeCategory = document.getElementById(categoryId);
    if (activeCategory) {
        activeCategory.style.display = 'block';
    }

    // Marcar la pestaña activa
    const menuLinks = document.querySelectorAll('.menu nav ul li a');
    menuLinks.forEach(function(link) {
        link.classList.remove('active');
    });
    const activeLink = document.querySelector('.menu nav ul li a[href="javascript:void(0);"][onclick="showCategory(\'' + categoryId + '\')"]');
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

// Establecer la categoría inicial (opcional)
document.addEventListener('DOMContentLoaded', function() {
    showCategory('sandwich');  // Inicialmente muestra la categoría de Sandwich
});