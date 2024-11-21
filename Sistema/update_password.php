<?php
include '../components/connection.php';  

// Cambia el correo y la contraseña aquí
$email = 'paredesgabriel784@gmail.com';
$nueva_contraseña = '1845'; // La contraseña que tiene el usuario
$hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

try {
    $update_user = $conn->prepare("UPDATE usuarios SET password_usuario = ? WHERE email = ?");
    $update_user->execute([$hashed_password, $email]);

    echo "Contraseña actualizada exitosamente.";
} catch (PDOException $e) {
    echo "Error al actualizar la contraseña: " . $e->getMessage();
}
?>
  