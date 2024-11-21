<?php
include '../components/connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];

    // Preparamos la consulta para obtener productos de la categoría solicitada
    $stmt = $conn->prepare("SELECT nombre_producto, precio, stock_producto FROM productos WHERE categoria = ?");
    $stmt->execute([$categoria]);

    if ($stmt->rowCount() > 0) {
        $productos = [];
        
        // Iteramos sobre los productos y los añadimos al array de respuesta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = [
                'name' => $row['nombre_producto'],
                'price' => $row['precio'], // Añadimos el precio
                'stock' => $row['stock_producto'] // Añadimos el stock
            ];
        }
        // Enviamos la respuesta en formato JSON
        echo json_encode(['status' => 'success', 'products' => $productos]);
    } else {
        // Si no hay productos disponibles en la categoría, enviamos un mensaje de error
        echo json_encode(['status' => 'error', 'message' => 'No hay productos disponibles en esta categoría.']);
    }
} else {
    // Si no se ha especificado la categoría, enviamos un error
    echo json_encode(['status' => 'error', 'message' => 'Categoría no especificada.']);
}
?>

