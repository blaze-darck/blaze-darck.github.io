<?php
session_start();

include '../components/connection.php'; // Conexión a la base de datos

if (isset($_POST['submit'])) {
    // Recibir y sanitizar datos del formulario
    $nombre = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass']; 
    $cpass = $_POST['cpass']; // Confirmación de la contraseña

    // Convertir la primera letra del nombre a mayúsculas
    $nombre = ucfirst(strtolower($nombre)); 

    // Verificar que las contraseñas coincidan
    if ($password !== $cpass) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hashear la contraseña solo después de verificar que coincidan
    $password_hashed = password_hash($password, PASSWORD_DEFAULT); 

    // Definir la ruta por defecto de la foto
    $foto = '../uploads/descarga.png'; // Foto por defecto

    // Comprobar si se ha subido una imagen
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Crear un nombre único para la imagen
        $nombre_foto = uniqid() . '-' . $_FILES['photo']['name'];
        $foto = '../uploads/' . $nombre_foto;
        
        // Mover la imagen subida a la carpeta "uploads"
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $foto)) {
            echo "Error al cargar la imagen.";
            exit;
        }
    }

    // Establecer el tipo de usuario (usuario por defecto)
    $tipo_usuario = 'usuario';

    // Insertar datos en la base de datos
    $query = "INSERT INTO usuarios (nombre_usuario, email, password_usuario, foto_perfil, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $email, $password_hashed, $foto, $tipo_usuario]);
    // Guardar datos en la sesión para el usuario recién registrado

    $user_id = $conn->lastInsertId();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $nombre;
    $_SESSION['user_email'] = $email;
    $_SESSION['foto_perfil'] = $foto;
    $_SESSION['tipo_usuario'] = $tipo_usuario; // Guardar tipo de usuario en sesión

    // Redirigir a la página principal
    header("Location: home.php");
    exit;
}
?>

<style type="text/css">
  <?php include '../css/style.css'; ?>
  <?php include '../css/footer.css'; ?>
  <?php include '../css/header.css'; ?>
  <?php include '../css/home.css'; ?>
  <?php include '../css/thumb.css'; ?>
  <?php include '../css/shop.css'; ?>
  <?php include '../css/descuento.css'; ?>
  <?php include '../css/servicios.css'; ?>
  <?php include '../css/about.css'; ?>
  <?php include '../css/contactos.css'; ?>
  <?php include '../css/chatbot.css'; ?>
  <?php include '../css/login.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Salesiano - REGISTRO</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="../img/loguito.png">
                <h1>Regístrate Ahora</h1>
                <p>¡Únete a nuestra comunidad!</p>
            </div>
            <form action="register.php" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <p>Tu nombre</p>
                    <input type="text" name="name" required placeholder="Ingresa tu nombre" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Tu email </p>
                    <input type="email" name="email" required placeholder="Ingresa tu email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Tu password </p>
                    <input type="password" name="pass" required placeholder="Ingresa tu password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Confirma tu password </p>
                    <input type="password" name="cpass" required placeholder="Ingresa tu password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Foto de perfil (opcional)</p>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <input type="submit" name="submit" value="Ingresa Ahora" class="btn">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
            </form>
        </section>
    </div>
</body>
</html>
