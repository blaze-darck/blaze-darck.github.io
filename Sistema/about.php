<?php
include 'components/connection.php';
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
    <div class="banner">
        <h1>Sobre nosotros</h1>
    </div>
    <div class="title2">
        <a href="home.php">Principio</a><span>about</span>
    </div>
    <section class="container">
      <div class="box-container">
        <div class="box">
          <img src="../img/sopa-fideo.png">
        </div>
        <div class="box">
          <img src="../img/loguito.png">
          <span>CAFE-SALESIANO</span>
          <h1>¿Quienes somos?</h1>
          <p>En el corazón de Achachicala, nuestro restaurante-cafetería te ofrece un ambiente acogedor y moderno donde 
            puedes disfrutar de una variedad de platos frescos y sabrosos, acompañados de café recién preparado. Ya sea que busques un desayuno energético, un 
            almuerzo reconfortante o un espacio para relajarte con amigos, este es el lugar ideal.</p>
        </div>
      </div>
     </section>
    </div>
    <?php include '../components/services.php'; ?> 
    <div class="about">
      <div class="row">
        <div class="img-box">
          <img src="../img/LN2sin.png">
        </div>
        <div class="detail">
          <h1>Visita nuestro hermoso establecimiento</h1>
          <p>Ven a disfrutar de nuestra comida en un ambiente tranqulo y acogedor </p>
          <a href="view_products.php" class="btn">Registrate</a>
        </div>
      </div>
    </div>
    <div class="testimonial-container">
    <div class="title">
        <img src="../img/loguito.png" class="logo" alt="Logo">
        <h1>COMENTARIOS</h1>
        <p>Comenetarios de nuestrs usuarios</p>
    </div>
    <div class="container">
        <div class="testimonial-item active">
            <img src="../img/01.jpg" alt="Sara Smith">
            <h1>Sara Smith</h1>
            <p>EStaba dura la maraqueta 
            </p>
        </div>
        <div class="testimonial-item">
            <img src="../img/02.jpg" alt="Jhon Smith">
            <h1>Jhon Smith</h1>
            <p>Cuadno mordi mi sandwicha desaparecio el huevo</p>
        </div>
        <div class="testimonial-item">
            <img src="../img/03.jpg" alt="Selena Smith">
            <h1>Selena Smith</h1>
            <p>El cafe estaba agradable</p>
        </div>
        <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
        <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
    </div>
</div>
    <?php include 'components/footer.php'; ?>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../scriptsS/script.js"></script>
  <script src="../scriptsS/scripthome.js"></script>
  <script src="../scriptsS/about.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html>