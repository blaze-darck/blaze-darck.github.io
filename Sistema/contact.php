<?php
include '../components/connection.php';
session_start();
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id = '';
}
if(isset($_POST['logout'])){
  session_destroy();
  header("location: login.php");
}
?>
<!--Incluyendo todos los css para dar el estilo a la pagina-->
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
  <?php include '../css/fontello.css'; ?>

</style>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <title>Pagina Principal - pagina de nosotros</title>
</head>
<body>
  
  <?php include '../components/header.php'; ?>
  <div class="main">
    <?php include '../components/services.php'; ?>
    <div class="form-container">
      <form method="post">
        <div class="title">
          <img src="../img/loguito.png" class="logo">
          <h1>Envianos un mensaje</h1>
        </div>
        <div class="input-field">
          <p> nombre</p>
          <input type="text" name="name" required placeholder="Ingresa tu nombre" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')>
        </div>
        <div class="input-field">
          <p> email</p>
          <input type="email" name="email" required placeholder="Ingresa tu email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')>
        </div>
        <div class="input-field">
          <p> numero</p>
          <input type="text" name="number" required placeholder="Ingresa tu numero de telefono" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')>
        </div>
        <div class="input-field">
          <p> mensaje</p>
          <textarea name="message"></textarea>
        </div>
        <button type="submit" name="submit-btn" class="btn">Enviar Mensaje</button>
      </form>
    </div>
    <div class="address">
        <div class="title">
          <img src="../img/loguito.png" class="logo">
          <h1>Detalle de Contacto</h1>
        </div>
        <div class="box-container">
          <div class="box">
            <i class="bx bxs-map-pin"></i>
            <div>
              <h4>Direccion</h4>
              <p>Zona Achachicala, Av. Chacaltaya Nro. 1258</p>
            </div>
          </div>
          <div class="box">
            <i class="bx bxs-phone-call"></i>
            <div>
              <h4>Numeros de Telefonos</h4>
              <p>77771981</p>
            </div>
          </div>
          <div class="box">
            <i class="bx bxs-map-pin"></i>
            <div>
              <h4>Email</h4>
              <p>gabrielparedes@gmial.com</p>
            </div>
          </div>
        </div>
      </div>
    <?php include '../components/footer.php'; ?>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../scriptsS/script.js"></script>
  <script src="../scriptsS/scripthome.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html>