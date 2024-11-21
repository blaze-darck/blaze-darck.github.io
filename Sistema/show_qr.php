<?php
session_start();

require '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Verificar que tenemos la URL del QR en la sesión
if (isset($_SESSION['qr_payment_url'])) {
    $payment_url = $_SESSION['qr_payment_url'];

    // Crear el objeto QR Code
    $qrCode = new QrCode($payment_url);

    // Generar la imagen QR en formato PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Mostrar la imagen QR directamente en el navegador
    header('Content-Type: ' . $result->getMimeType());
    echo $result->getString();

    // Establecer un temporizador de redirección usando JavaScript
    echo "
    <script>
        setTimeout(function() {
            window.location.href = 'view_products.php'; // Redirigir a la página de productos
        }, 5000); // Esperar 5 segundos antes de redirigir
    </script>";
    
    // Limpiar los datos de la sesión después de usarlo
    unset($_SESSION['qr_payment_url']);
    unset($_SESSION['qr_shown_time']);
} else {
    echo "<p>Error: No se encontraron datos del producto.</p>";
}
?>
