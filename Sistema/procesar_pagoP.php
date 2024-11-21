<?php
// Asegúrate de que esta página esté protegida, es decir, que se redirija a ella solo si el pago fue exitoso

echo "<div class='completed-container'>";
echo "<h2>Pago Completado Exitosamente</h2>";
echo "<p>Gracias por su compra. El pago ha sido procesado con éxito.</p>";
echo "</div>";
?>

<!-- Estilos CSS para la página de confirmación -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .completed-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    h2 {
        color: #28a745;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        font-size: 1rem;
    }
</style>
