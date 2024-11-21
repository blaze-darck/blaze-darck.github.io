<?php
session_start();
include '../components/connection.php'; // Conexión a la base de datos

require '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Verificar que todos los datos necesarios fueron enviados a través de AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobar si la sesión contiene un user_id válido
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        echo "Error: Usuario no autenticado.";
        exit;
    }

    // Recibir datos del formulario o del AJAX (productos, cantidades, etc.)
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $qty = $_POST['qty'];

    // Verificar si faltan datos
    if (empty($product_id) || empty($product_name) || empty($price) || empty($qty)) {
        echo "Faltan datos para generar el QR.";
        exit;
    }

    // Crear el total de la compra
    $total = $price * $qty;
    $payment_info = "Nombre: $product_name, Precio: $total Bs";
    $qr_id = uniqid('QR_'); // ID único para el QR

    // URL para el pago que incluirá el user_id
    $payment_url = "http://192.168.0.10:8000/cafe3.0/pagar.php?info=" . urlencode($payment_info) . "&qr_id=" . urlencode($qr_id) . "&user_id=" . urlencode($user_id);

    try {
        // Generar el QR
        $qrCode = new QrCode($payment_url);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Guardar el QR en la base de datos
        $insert_qr = $conn->prepare("INSERT INTO qrs (qr_id, id_usuario, id_producto) VALUES (?, ?, ?)");
        $insert_qr->execute([$qr_id, $user_id, $product_id]);

        // Convertir la imagen a base64 y devolverla
        echo base64_encode($result->getString());

    } catch (Exception $e) {
        echo "Error al generar el QR: " . $e->getMessage();
    }
}
?>
