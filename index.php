<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Cafe Salesiano</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Si tienes un estilo base -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .welcome-container {
            text-align: center;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
        }
        .welcome-container h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .welcome-container p {
            color: #555555;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .welcome-container a {
            text-decoration: none;
            color: #ffffff;
            background: #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            margin: 0 10px;
            transition: background 0.3s ease;
        }
        .welcome-container a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>¡Bienvenido a Cafe Salesiano!</h1>
        <p>Por favor, inicia sesión o regístrate para continuar.</p>
        <a href="/cafe3.0/Sistema/login.php">Iniciar Sesión</a>
        <a href="/cafe3.0/Sistema/register.php">Registrarse</a>
    </div>
</body>
</html>
