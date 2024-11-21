<header class="header">
    <div class="flex">
        <!-- Barra de navegacion -->
        <div class="btn-menu">
            <label for="btn-menu"class="icon-menu"></label>
        </div>

        <input type="checkbox"id="btn-menu">
        <div class="container-menu">
            <div class="cont-menu">
                <nav>
                <a href="home.php">Inicio</a>
                <a href="view_products.php">Productos</a>
                
                <a href="about.php">Sobre Nosotros</a>
                <a href="contact.php">Contáctenos</a>
                </nav>
                <label for="btn-menu">x</label>
            </div>

        </div>
        <a href="home.php" class="logo"><img src="../img/SALESIA2.png" alt="LOGO" class="LOGO"></a>

        
        <div class="icons">
            <!-- Imagen de perfil del usuario -->
            <img src="<?= isset($_SESSION['foto_perfil']) && file_exists($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../uploads/default.jpg'; ?>" id="user-btn" alt="Foto de perfil" style="cursor:pointer;">
            
            <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin') : ?>
                <i class="bx bx-plus" id="add-product-btn" style="cursor:pointer;" title="Agregar Producto"></i>
                <a href="ver_qr_usuarios.php" class="btn-qr-list" style="text-decoration: none;">
                    <i class="bx bx-qr" style="cursor:pointer;" title="Ver lista de QR generados"></i>
                </a>
            <?php endif; ?>
        </div>    
            <div class="user-box" id="user-box" style="display: none;">
                <p>Nombre Usuario : <span><?= $_SESSION['user_name'] ?? 'Usuario' ?></span></p>
                <p>Email : <span><?= $_SESSION['user_email'] ?? 'Sin correo' ?></span></p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="post" action="login.php">
                        <button type="submit" name="logout" class="logout-btn">Salir del Sistema</button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="btn">Iniciar Sesión</a>
                    <a href="register.php" class="btn">Registrarse</a>
                <?php endif; ?>
            </div>

        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'usuario') : ?>
            <div class="chatbot-icon" id="chatbot-icon" data-username="<?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>" style="cursor: pointer;">💬</div>

    <!-- Contenedor del chatbot -->
            <div class="chatbot-container" id="chatbot-container">
                <div class="chat-content">
                    <div id="chat-messages">
                        <p>Envía "hola" para iniciar la conversación.</p>
                    </div>
                    <div style="display: flex;">
                        <input type="text" id="chat-input" placeholder="Escribe un mensaje..." />
                        <button id="send-btn">Enviar</button>
                    </div>
                </div>
                <button id="close-chatbot-btn">Cerrar</button>
            </div>
        <?php endif; ?>

        
    </div>
</header>

<?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin') : ?>
    <div id="product-form" style="display:none;" class="product-form">
        <h2>Agregar Producto</h2>
        <form action="components/incercion.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="nombre" required>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" required>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required>

            <label for="detalle">Detalle:</label>
            <textarea name="detalle" required></textarea>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" required>

            <label for="categoria">Categoría:</label>
            <select name="categoria" required>
                <option value="sandwich">Sandwich</option>
                <option value="segundos">Segundos</option>
                <option value="sopas">Sopas</option>
                <option value="bebidas">Bebidas</option>
                <option value="aperitivos">Aperitivos</option>
            </select>

            <button type="submit">Insertar</button>
        </form>
    </div>
<?php endif; ?>

<!-- Scripts del archivo header -->
<script src="../scriptsS/agregarp.js"></script>
<script src="../scriptsS/chatbot.js"></script>
<script src="../scriptsS/foto_perfil.js"></script>
<script src="../scriptsS/text.js"></script>
<script src="../scriptsS/cont-products.js"></script>



