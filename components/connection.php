<?php
// Cargar el autoloader de Composer desde la raíz del proyecto
require_once __DIR__ . '/../vendor/autoload.php';  // El '..' sube un nivel a la raíz

// Cargar las variables de entorno desde el archivo .env (que está en la raíz)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // El '..' sube un nivel hasta la raíz
$dotenv->load();  // Cargar el archivo .env

// Verifica que las variables de entorno están correctamente cargadas
if (!isset($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])) {
    echo "Faltan variables de entorno necesarias.";
    exit();
}

// Obtener las variables de entorno
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];

try {
    // Crear la conexión PDO
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Mostrar el mensaje de error de conexión si ocurre un fallo
    echo "Error de conexión: " . $e->getMessage();
    exit(); // Termina la ejecución si no hay conexión
}
?>
