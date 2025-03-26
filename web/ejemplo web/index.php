<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php
// Inicia la sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si hay una sesión activa
if (!empty($_SESSION['id'])) {
    // Si hay una sesión activa, redirige al home
    header("location: project/home_usuario.php");
    exit(); // Asegura que el script se detenga después de la redirección
}
?>
    <div id="container">
        <div id="logo-container">
          <a href="index.html"><img id="logo" src="img/logo.png" alt="Logo"></a>
            <div id="title">Velodromo Marino Lejarreta</div>
            <div id="collaboration-section">
                <h2>Colaboración con</h2>
                <a href=https://maristak.com><img id="collaboration-logo" src="img/maristak.png" alt="Maristak"></a>
            </div>
        </div>
        <div id="button-container">
            <input type="button" class="button large-button" onclick="window.location.href='project/iniciar_sesion.php'" value="Iniciar Sesión">
            <input type="button" class="button large-button" onclick="window.location.href='project/registro.php'" value="Registrate">
        </div>
    </div>

    <div id="footer">
        <a url="www.reconfia.com">www.reconfia.com</a>
    </div>
</body>
</html>
