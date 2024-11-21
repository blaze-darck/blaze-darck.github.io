<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios que Generaron QR</title>
    <link rel="stylesheet" href="../css/verusuarios.css">
</head>
<body>
    <header>
        <h1>Lista de Usuarios que Generaron QR</h1>
    </header>
    <main>
        <button onclick="window.location.href='generate_pdf.php'">Descargar Resumen en PDF</button>
        <table id="qr-table">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>ID del QR</th>
                    <th>Fecha de Creación</th>
                    <th>Estado</th>
                    <th>Producto Escaneado</th>
                    <th>Precio del Producto (Bs)</th>
                    <th>Stock Producto</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargarán los usuarios -->
            </tbody>
        </table>
    </main>
    <script>
        function updateUserList() {
            fetch('get_users.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#qr-table tbody');
                    tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos
                    data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.nombre_usuario}</td>
                            <td>${user.email}</td>
                            <td>${user.qr_id}</td>
                            <td>${user.fecha_creacion}</td>
                            <td>${user.estado}</td>
                            <td>${user.producto_escaneado}</td>
                            <td>${user.precio_producto}</td>
                            <td>${user.stock_producto}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al actualizar la lista de usuarios:', error));
        }

        // Cargar la lista de usuarios cuando la página se haya cargado
        document.addEventListener('DOMContentLoaded', updateUserList);
    </script>
</body>
</html>
