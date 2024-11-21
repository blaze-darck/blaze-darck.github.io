<?php
include 'connection.php';

try {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $detalle = $_POST['detalle'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];  // Captura la categoría

    // Procesar la imagen
    $imagen = $_FILES['imagen']['tmp_name'];
    $imageData = file_get_contents($imagen);

    // Consulta para verificar si el producto ya existe
    $sqlCheck = "SELECT COUNT(*) FROM productos WHERE nombre_producto = :nombre";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bindParam(':nombre', $nombre);
    $stmtCheck->execute();

    // Consulta de inserción
    if ($stmtCheck->fetchColumn() == 0) {
        $sqlInsert = "INSERT INTO productos (nombre_producto, precio, imagen_producto, detalle_producto, stock_producto, categoria) 
                      VALUES (:nombre, :precio, :imagen, :detalle, :stock, :categoria)";  // Agregar 'categoria'
        $stmtInsert = $conn->prepare($sqlInsert);

        // Asignar los valores
        $stmtInsert->bindParam(':nombre', $nombre);
        $stmtInsert->bindParam(':precio', $precio);
        $stmtInsert->bindParam(':imagen', $imageData, PDO::PARAM_LOB);
        $stmtInsert->bindParam(':detalle', $detalle);
        $stmtInsert->bindParam(':stock', $stock);
        $stmtInsert->bindParam(':categoria', $categoria);  // Asignar la categoría

        $stmtInsert->execute();
        header("Location: /view_products.php");
        exit();
    } else {
        echo "El producto '{$nombre}' ya existe. No se insertó.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn = null;
}
?>
