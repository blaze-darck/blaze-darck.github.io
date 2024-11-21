<?php
include '../components/connection.php'; // Conexión a la base de datos

// Verificar si se han enviado los datos desde el formulario de pago
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_info']) && isset($_POST['qr_id'])) {
    $payment_info = $_POST['payment_info'];  // Información del pago
    $qr_id = $_POST['qr_id'];  // ID del QR

    // Asegúrate de que la información de pago y el qr_id son válidos
    if (!empty($payment_info) && !empty($qr_id)) {
        // Aquí puedes hacer la lógica de procesamiento de pago (simulada)
        $payment_successful = true; // Simulamos que el pago fue exitoso

        if ($payment_successful) {
            // Actualizar el estado del QR a 'usado' en la base de datos
            $stmt = $conn->prepare("UPDATE qrs SET estado = 'usado' WHERE qr_id = :qr_id");
            $stmt->bindParam(':qr_id', $qr_id);
            $stmt->execute();

            // Obtener el id_producto asociado al QR
            $stmt = $conn->prepare("SELECT id_producto FROM qrs WHERE qr_id = :qr_id");
            $stmt->bindParam(':qr_id', $qr_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $id_producto = $result['id_producto'];

                // Disminuir el stock del producto en 1
                $stmt = $conn->prepare("UPDATE productos SET stock_producto = stock_producto - 1 WHERE id_producto = :id_producto");
                $stmt->bindParam(':id_producto', $id_producto);
                $stmt->execute();

                // Verificar el stock actual después de la actualización
                $stmt = $conn->prepare("SELECT stock_producto FROM productos WHERE id_producto = :id_producto");
                $stmt->bindParam(':id_producto', $id_producto);
                $stmt->execute();
                $stock = $stmt->fetchColumn();

                if ($stock <= 0) {
                    echo json_encode(['status' => 'warning', 'message' => 'Producto inexistente, no hay más stock disponible.']);
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Pago completado exitosamente']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado para el QR proporcionado.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al procesar el pago.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos de pago incorrectos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se enviaron los datos correctamente.']);
}
?>

