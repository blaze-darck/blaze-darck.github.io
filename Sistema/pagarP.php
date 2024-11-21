<?php
include '../components/connection.php'; // Conexión a la base de datos

// Verificar si se han pasado los parámetros por GET
if (isset($_GET['info']) && isset($_GET['total'])) {
    $order_details = urldecode($_GET['info']); // Decodificar los detalles del pedido
    $total_price = $_GET['total']; // Total del pedido

    // Mostrar los detalles del pedido y el total para depuración
    echo "<div class='payment-container'>";
    echo "<h2>Detalles del Pedido</h2>";
    echo "<p><strong>Productos:</strong> $order_details</p>";
    echo "<p><strong>Total a pagar:</strong> $$total_price</p>";

    // Formulario de pago
    echo '<form action="" method="POST" id="paymentForm" class="payment-form">
            <input type="hidden" name="payment_info" value="' . htmlspecialchars($order_details) . '">
            <input type="hidden" name="total_price" value="' . htmlspecialchars($total_price) . '">
            <button type="submit" name="pay_button" class="btn-pay">Pagar</button>
          </form>';
    echo "</div>";
} else {
    echo "<p><strong>Error:</strong> Parámetros 'info' y/o 'total' no recibidos correctamente.</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_info']) && isset($_POST['total_price'])) {
    // Aquí simularíamos que el pago fue exitoso
    $payment_info = $_POST['payment_info'];
    $total_price = $_POST['total_price'];

    // Aquí se podría hacer la validación del pago o la lógica de pagos, por ahora lo simulamos como exitoso
    $payment_successful = true;

    if ($payment_successful) {
        // Redirigir a la página de "Pago Completado" en vez de mostrar mensaje
        header("Location: procesar_pagoP.php");
        exit; // Aseguramos que la redirección no continúe con el resto del código.
    } else {
        echo "<p><strong>Error al procesar el pago.</strong></p>";
    }
}
?>

<!-- Estilos CSS -->
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

    .payment-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    h2 {
        color: #2e3a59;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .payment-form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .payment-form input {
        display: none;
    }

    .btn-pay {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .btn-pay:hover {
        background-color: #0056b3;
    }

    .btn-pay:active {
        background-color: #004085;
    }

    /* Mensajes de error */
    .error-message {
        color: red;
        font-size: 1rem;
        margin-top: 20px;
    }

    .success-message {
        color: green;
        font-size: 1rem;
        margin-top: 20px;
    }
</style>
