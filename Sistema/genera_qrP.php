<?php
// Asegúrate de que la librería QRCode esté instalada (usando Composer)
require '../vendor/autoload.php'; // Asegúrate de tener la librería instalada con Composer

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Recibe los datos JSON enviados desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

// Verifica que los datos del pedido y el precio hayan sido enviados
if (!isset($data['order_details']) || !isset($data['total_price'])) {
    // Si faltan los datos, devuelve un error
    echo json_encode(['success' => false, 'message' => 'Datos del pedido incompletos.']);
    exit;
}

// Extraemos los datos del pedido y el total
$orderDetails = $data['order_details'];  // Detalles del pedido
$totalPrice = $data['total_price'];      // Total del pedido

// Generar un ID único para el QR
$qr_id = uniqid('QR_');  // ID único para el QR

// Aquí creamos la URL que se codificará en el QR, con los detalles del pedido y el total
$paymentUrl = "http://192.168.0.14:8000/cafe3.0/pagarP.php?info=" . urlencode($orderDetails) . "&total=" . urlencode($totalPrice) . "&qr_id=" . urlencode($qr_id);

// Crear el objeto QR con la URL que queremos codificar
$qrCode = new QrCode($paymentUrl);
$writer = new PngWriter();

try {
    // Genera la imagen del QR
    $result = $writer->write($qrCode);

    // Convierte la imagen QR a base64
    $qrImageBase64 = base64_encode($result->getString());

    // Devuelve la imagen QR en base64 al frontend
    echo json_encode([
        'success' => true,
        'qr_image' => $qrImageBase64  // La imagen QR codificada en base64
    ]);
} catch (Exception $e) {
    // Si hay algún error al generar el QR, devuelve el mensaje de error
    echo json_encode([
        'success' => false,
        'message' => 'Error al generar el código QR: ' . $e->getMessage()
    ]);
}
?>

