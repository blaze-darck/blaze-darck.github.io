<?php
include '../components/connection.php';  // Conexión a la base de datos
session_start();
$message = [];  

if (isset($_POST['submit'])) {
    // Recibir datos del formulario
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    
    // Eliminar espacios extra
    $email = trim($email);
    $pass = trim($pass);

    // Verificar si el correo existe en la base de datos
    $select_user = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $select_user->execute([$email]);

    if ($select_user->rowCount() > 0) {
        $user = $select_user->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($pass, $user['password_usuario'])) {
            // Las credenciales son correctas, crear la sesión
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nombre_usuario'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['foto_perfil'] = $user['foto_perfil'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario']; 
            
            header("Location: home.php");
            exit;
        } else {
            $message[] = "Contraseña incorrecta.";
        }
    } else {
        $message[] = "El correo no está registrado.";
    }
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
    <title>Cafe Salesiano - Inicio de sesión</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="../img/loguito.png">
                <h1>Inicia sesión ahora</h1>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Tu email </p>
                    <input type="email" name="email" required placeholder="Ingresa tu email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Tu password </p>
                    <input type="password" name="pass" required placeholder="Ingresa tu password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Iniciar sesión" class="btn">
                <p>¿Aún no estás registrado? <a href="register.php">Regístrate ahora</a></p>
            </form>
        </section>
    </div>
</body>
</html>
