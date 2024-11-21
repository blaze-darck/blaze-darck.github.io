<?php
include '../components/connection.php'; // Asegúrate de que la conexión esté configurada correctamente

// Habilitar la depuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificamos si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos de la solicitud (el ID del producto y la cantidad)
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['productos']) && is_array($data['productos'])) {
        try {
            // Iniciamos la transacción para asegurarnos de que todo se actualiza correctamente
            $conn->beginTransaction();

            // Recorremos los productos recibidos
            foreach ($data['productos'] as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];

                // Verificamos si los datos recibidos son válidos
                if (!is_numeric($cantidad) || !is_numeric($id_producto)) {
                    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
                    exit();
                }

                // Verificamos si el producto existe y obtenemos el stock actual
                $stmt_check = $conn->prepare("SELECT stock_producto FROM productos WHERE id_producto = :id_producto");
                $stmt_check->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
                $stmt_check->execute();
                $current_stock = $stmt_check->fetchColumn();

                // Si no encontramos el producto, devolvemos un error
                if ($current_stock === false) {
                    echo json_encode(['status' => 'error', 'message' => "Producto con ID $id_producto no encontrado."]);
                    exit();
                }

                // Imprimimos para depuración (esto aparecerá en el log de errores)
                error_log("ID Producto: $id_producto, Cantidad solicitada: $cantidad, Stock actual: $current_stock");

                // Verificamos si hay suficiente stock
                if ($current_stock < $cantidad) {
                    echo json_encode(['status' => 'error', 'message' => 'No hay suficiente stock para el producto ID ' . $id_producto]);
                    exit();
                }

                // Realizamos la actualización del stock restando la cantidad solicitada
                $stmt = $conn->prepare("UPDATE productos SET stock_producto = stock_producto - :cantidad WHERE id_producto = :id_producto");
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
                $stmt->execute();

                // Verificamos si la actualización fue exitosa
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['status' => 'success', 'message' => "Stock actualizado para producto ID: $id_producto, cantidad restada: $cantidad"]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => "No se pudo actualizar el stock para producto ID: $id_producto"]);
                }
            }

            // Si todo fue bien, confirmamos la transacción
            $conn->commit();
        } catch (Exception $e) {
            // Si ocurre un error, revertimos la transacción
            $conn->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el stock: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>


