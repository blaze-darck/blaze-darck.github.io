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
<style type="text/css">
  <?php include '../css/style.css'; ?>
  <?php include '../css/footer.css'; ?>
  <?php include '../css/header.css'; ?>
  <?php include '../css/home.css'; ?>
  <?php include '../css/thumb.css'; ?>
  <?php include '../css/shop.css'; ?>
  <?php include '../css/descuento.css'; ?>
  <?php include '../css/servicios.css'; ?>
  <?php include '../css/chatbot.css'; ?>
  <?php include '../css/fontello.css'; ?>
  <?php include '../css/about.css'; ?>

</style>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <title>CAFE-SALESIANO|| HOME</title>
</head>
<body>
  
  <?php include '../components/header.php'; ?>
  <div class="main">
  <section class="home-section">
    <div class="slider">
        <div class="slider_slider slide1">
        </div>
        <div class="slider_slider slide2">
        </div>
        <div class="slider_slider slide3">
        </div>
        <div class="slider_slider slide4">
        </div>
    </div>
</section>   
   
    <!-- Fin seccion home -->
     <!--Inicio de la seccion de muestra de categorias-->
     <section class="thumb">
      <div class="box-container">
        <div class="box">
          <img src="../img/1-P.png">
          <h3>Bebidas Calientes</h3>
          <a href="view_products.php" class="btn"></a>
        </div>
        <div class="box">
          <img src="../img/2-P.png">
          <h3>Masitas</h3>
          <a href="view_products.php" class="btn"></a>
        </div>
        <div class="box">
          <img src="../img/3-P.png">
          <h3>Sandwitches</h3>
          <a href="view_products.php" class="btn"></a>
        </div>
        <div class="box">
          <img src="../img/4-P.png">
          <h3>Bebidas Frias</h3>
          <a href="view_products.php" class="btn"></a>
        </div>
      </div>
     </section>
     <!-- Fin seccion muestra productos-->
     <!--Inicio Seccion iformacion-->
     <section class="container">
  <div class="transparent-container">
    <div class="box">
      <img src="../img/comi.jpeg" alt="Imagen de Salesia" class="info-img">
    </div>
    <div class="box">
      <p>Salesia fue lanzado por nuestro amor por la buena comida y el servicio eficiente y no intrusivo, dando una oportunidad a los estudiantes de nuestra universidad para prepararse y salir con una experiencia laboral.</p>
      <p>Nuestra misión de equipo es crear un hogar para los amantes de la comida con un ambiente acogedor, accesible para todas las edades. Somos un pequeño restaurante de barrio con una gran reputación y un emocionante desayuno todo el día.</p>
      <a href="view_products.php" class="btn">MENU</a>
    </div>
  </div>
</section>
      <!--Inicio de comentarios-->
      <div class="testimonial-container">
    <div class="title">
        <h1>COMENTARIOS</h1>
        <h3>RESEÑAS DE ULTIMOS CLIENTES</h3>
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
     
    <!--Inicio de mapa -->
    <div class="form-container">
      <form method="post">
        <div class="title">
          <h1>DONDE ENCONTRARNOS</h1>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7651.929077836132!2d-68.15563951373164!3d-16.477333167500497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915edffbe7677a7d%3A0xce3ee13e9e12ee12!2sUniversidad%20Salesiana%20de%20Bolivia!5e0!3m2!1ses!2sbo!4v1731322046713!5m2!1ses!2sbo" 
      width="1500"
      height="450"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
      </form>
    </div>
      <?php include '../components/services.php'; ?>  
    <?php include '../components/footer.php'; ?>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../scriptsS/script.js"></script>
  <script src="../scriptsS/scripthome.js"></script>
  <script src="../scriptsS/text.js"></script>
  <script src="../scriptsS/slider.js"></script>
  <script src="../scriptsS/about.js"></script>

  <?php include '../components/alert.php'; ?>
</body>
</html>
