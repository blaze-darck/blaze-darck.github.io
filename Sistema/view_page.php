<?php
include '../components/connection.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
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
  <?php include '../css/view_products.css'; ?>   
  <?php include '../css/view_page.css'; ?> 
  <?php include '../css/chatbot.css'; ?> 
  <?php include '../css/fontello.css'; ?>

</style>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <title>Página Principal - página de detalles productos</title>
</head>
<body>
  
  <?php include '../components/header.php'; ?>
  
  <div class="main">
    <div class="banner">
        <h1>Detalles de los productos</h1>
    </div>
    <div class="title2">
    </div>
    
    <section class="view_page">
<?php
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `productos` WHERE id_producto = :pid");
    $select_products->bindParam(':pid', $pid, PDO::PARAM_INT);
    $select_products->execute();
    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
?>
    <form id="generateQrForm_<?php echo $fetch_products['id_producto']; ?>" method="post" action="genera_qr.php" class="box">
        <img src="data:image/jpeg;base64,<?= base64_encode($fetch_products['imagen_producto']); ?>" alt="Producto">
        <div class="detail">
            <div class="price"><?php echo $fetch_products['precio']; ?> Bs</div>
            <div class="name"><?php echo $fetch_products['nombre_producto']; ?></div>
            <div class="product-detail">
                <p><?php echo $fetch_products['detalle_producto']; ?></p>
            </div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id_producto']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['nombre_producto']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['precio']; ?>">
            <input type="hidden" name="qty" value="1">
            <div class="button">
                <button type="button" class="btn generateQrBtn" data-product-id="<?php echo $fetch_products['id_producto']; ?>">Generar QR</button>
            </div>
        </div>
    </form>
<?php
        }
    } else {
        echo "<p>No se encontró el producto.</p>";
    }
}
?>
</section>
    <?php include '../components/footer.php'; ?>
  </div>
  
  <!-- JavaScript para generar el QR en ventana emergente -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
    // Cuando se haga clic en el botón "Generar QR"
    $('.generateQrBtn').on('click', function() {
        var productId = $(this).data('product-id'); // Obtener el ID del producto
        var form = $('#generateQrForm_' + productId); // Seleccionar el formulario correspondiente

        // Usar AJAX para enviar el formulario sin recargar la página
        $.ajax({
            type: 'POST',
            url: 'genera_qr.php',  // El archivo que genera el QR
            data: form.serialize(), // Serializar el formulario
            success: function(response) {
                // La respuesta es la imagen del QR en base64
                var popupWindow = window.open("", "popup", "width=400,height=400");
                popupWindow.document.write("<html><body><img src='data:image/png;base64," + response + "' alt='QR Code' style='max-width:100%; height:auto;'></body></html>");
                
                // Agregar un temporizador para cerrar la ventana emergente después de 5 segundos
                setTimeout(function() {
                    popupWindow.close(); // Cierra la ventana después de 5 segundos
                }, 5000); // 5000 milisegundos (5 segundos)
            },
            error: function(xhr, status, error) {
                alert("Error al generar el QR");
            }
        });
    });
  });
  </script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../scriptsS/script.js"></script>
  <script src="../scriptsS/scripthome.js"></script>
  <script src="../scriptsS/about.js"></script>
  <script src="../scriptsS/agregarp.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html>
