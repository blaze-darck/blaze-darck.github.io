<?php
include '../components/connection.php';

session_start();

if (isset($_GET['info']) && isset($_GET['qr_id'])) {
    $payment_info = urldecode($_GET['info']); // Decodifica el parámetro info recibido desde el QR
    $qr_id = $_GET['qr_id']; // Obtener el qr_id

    if (!empty($payment_info)) {
        echo "<div class='payment-container'>";
        echo "<h2>Información de Pago</h2>";
        echo "<p>" . htmlspecialchars($payment_info) . "</p>";

        // Mostrar el formulario de pago
        echo '<form id="paymentForm" class="payment-form">';
        echo '<input type="hidden" name="payment_info" value="' . htmlspecialchars($payment_info) . '">';
        echo '<input type="hidden" name="qr_id" value="' . htmlspecialchars($qr_id) . '">';
        echo '<button type="submit" id="payButton" class="btn-pay">Pagar</button>';
        echo '</form>';

        // Código JavaScript para manejar el envío del formulario con AJAX
        echo '
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $("#paymentForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "sistema_pago.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message);
                            window.opener.updateQRCodeStatus();
                            window.close();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Ocurrió un error al procesar el pago.");
                    }
                });
            });
        </script>';
        echo "</div>";

    } else {
        echo "<p>Información de pago no válida.</p>";
    }
} else {
    echo "<p>Información de pago no válida.</p>";
}
?>

<!-- Agregar estilo CSS -->
<style>
    /* Estilos generales */
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

