<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div id="container">
        <div id="logo-container">
          <a href="../index.php"><img id="logo" src="../img/logo.png" alt="Logo"></a>
            <div id="title">Velodromo Marino Lejarreta</div>
            <div id="collaboration-section">
                <h2>Colaboración con</h2>
                <a href=https://maristak.com><img id="collaboration-logo" src="../img/maristak.png" alt="Maristak"></a>
            </div>
        </div>
        <div id="button-container">
        <div id="login-form">
            <h2>Iniciar sesion</h2>
            <form method="post" action="./home_usuario.php">
                <label for="user">Usuario:</label>
                <input type="text" name="user" required maxlength="255">

                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" required maxlength="255">

                <button type="submit" name="botonlogin" class="button_registro">Iniciar sesión</button>
                <br><br>
                <a href="registro.php">¿Todavía no estás registrado?</a>
            </form>
        </div>
        </div>
    </div>
    <div id="footer">
        <a url="www.reconfia.com">www.reconfia.com</a>
    </div>
</body>
</html>