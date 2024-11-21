<?php
session_start();
require '../components/connection.php'; // Conexión a la base de datos
require '../vendor/autoload.php'; // Cargar Dompdf

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si la clase Dompdf está disponible
if (!class_exists('Dompdf\Dompdf')) {
    echo "Error: La clase Dompdf\Dompdf no se encuentra.<br>";
    exit;
}

use Dompdf\Dompdf;

// Verificar si el usuario es administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// Consulta a la base de datos sin agrupación
$query = "
    SELECT 
        qrs.fecha_creacion AS fecha,
        usuarios.nombre_usuario AS cliente,
        productos.nombre_producto AS producto,
        productos.precio AS total_producto,
        1 AS cantidad  -- Cada venta individual se cuenta como 1
    FROM 
        qrs
    JOIN 
        usuarios ON qrs.id_usuario = usuarios.id_usuario
    JOIN 
        productos ON qrs.id_producto = productos.id_producto
    WHERE 
        qrs.estado = 'usado'  -- Asegúrate de que solo se seleccionen los QR usados
    ORDER BY 
        qrs.fecha_creacion DESC;  -- Ordenar por fecha de creación
";

$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($data)) {
    echo "No se encontraron datos para generar el reporte.";
    exit;
}

// Generar HTML para el PDF
$html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            h1 { text-align: center; color: #333; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            th, td { border: 1px solid #ddd; text-align: left; padding: 8px; }
            th { background-color: #f4f4f4; }
            .page-break { page-break-before: always; }
        </style>
    </head>
    <body>
        <h1>Resumen de Ventas por Día</h1>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Total (Bs)</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>';

// Generar las filas dinámicas de la tabla a partir de los datos de la base de datos
foreach ($data as $index => $row) {
    $html .= "
        <tr>
            <td>{$row['fecha']}</td>
            <td>{$row['cliente']}</td>
            <td>{$row['producto']}</td>
            <td>" . number_format($row['total_producto'], 2) . "</td>
            <td>{$row['cantidad']}</td>
        </tr>";

    // Agregar salto de página después de cierto número de registros (20 en este ejemplo)
    if (($index + 1) % 20 == 0) {
        $html .= '<div class="page-break"></div>';
    }
}

$html .= '</tbody></table></body></html>';

// Crear una instancia de Dompdf y cargar el contenido HTML
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Configurar tamaño de papel y orientación (horizontal)
$dompdf->setPaper('A4', 'landscape');

// Habilitar el parser HTML5 y PHP
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isPhpEnabled', true);

// Renderizar el PDF
$dompdf->render();

// Forzar la descarga del archivo PDF
$dompdf->stream("resumen_ventas.pdf", ["Attachment" => true]);
?>
