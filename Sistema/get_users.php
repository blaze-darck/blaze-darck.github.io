<?php
require '../components/connection.php'; // Asegúrate de que la conexión esté bien configurada

// Consulta para obtener los datos
$query = "
    SELECT 
        usuarios.nombre_usuario,
        usuarios.email,
        qrs.qr_id,
        qrs.fecha_creacion,
        qrs.estado,
        productos.nombre_producto AS producto_escaneado,
        productos.precio AS precio_producto,
        productos.stock_producto
    FROM 
        qrs
    JOIN 
        usuarios ON qrs.id_usuario = usuarios.id_usuario
    JOIN 
        productos ON qrs.id_producto = productos.id_producto
    ORDER BY 
        qrs.fecha_creacion DESC;
";

$stmt = $conn->prepare($query);
$stmt->execute();
$qr_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Aseguramos que los datos se devuelvan correctamente como JSON
header('Content-Type: application/json');
echo json_encode($qr_users);
?>
