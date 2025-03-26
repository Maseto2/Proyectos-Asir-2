<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
            <h2>Registro</h2>
             <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required maxlength="255" placeholder="Escribe aqui tu nombre">
                <label for="apellido">Apellido:</label>
                <input type="text"  name="apellido" required maxlength="255" placeholder="Escribe aqui tu apellido">
                <label for="username">Email:</label>
                <input type="mail" name="mail" required maxlength="255" placeholder="Introduce tu correo electrónico">
                <label for="username">Nombre de usuario:</label>
                <input type="text" name="user" required maxlength="255" placeholder="Crea tu nombre de usuario">
                <label for="password">Contraseña:</label>
                <input type="password" name="contrasena" required maxlength="255" placeholder="Escribe una contraseña">
                <label for="password">Repetir Contraseña:</label>
                <input type="password" name="contrasena2" required maxlength="255" placeholder="Repite tu contraseña">
                <button type="submit" name="botonregistro" class="button_registro">Registrarse</button>
            </form> 
            <a href="iniciar_sesion.php">¿Ya te has registrado? Inicia sesión</a>
        </div>
        </div>
    </div>  
    <?php
include_once '../persistence/MySQLPDO.class.php';
include_once '../entity/usuario.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['botonregistro'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $mail = $_POST['mail'];
    $user = $_POST['user'];
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];

    // Verificar si algún campo del formulario ha sido enviado
    if (!empty($nombre) && !empty($apellido) && !empty($mail) && !empty($user) && !empty($contrasena) && !empty($contrasena2)) {
        $contrasenacif = md5($contrasena);
        MySQLPDO::connect();
        $repetido = MySQLPDO::buscarUsuario($user);

        if (sizeof($repetido) == 0) {
            if ($contrasena == $contrasena2) {
                $objusuario = new usuario();
                $objusuario->setNombre($nombre);
                $objusuario->setApellido($apellido);
                $objusuario->setUser($user);
                $objusuario->setContrasena($contrasenacif);
                $objusuario->setMail($mail);
                $objusuario->setRol('2');

                MySQLPDO::connect();
                $resultado = MySQLPDO::insertarUsuario($objusuario);

                if ($resultado != 0) {
                    echo '<script>';
                    echo 'Swal.fire({
                        text: "Usuario registrado correctamente",
                      });';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'Swal.fire({
                        text: "Error, no se ha podido registrar el usuario.",
                      });';
                    echo '</script>';
                }
            } else {
                echo '<script>';
                echo 'Swal.fire({
                    text: "Error, las contraseñas no coinciden.",
                  });';
                echo '</script>';
            }
        } else {
            echo '<script>';
            echo 'Swal.fire({
                text: "Este nombre de usuario está en uso. Elige uno distinto.",
              });';
            echo '</script>';
        }
    } else {
        // No hacer nada si el formulario está vacío al cargar la página
    }
}
?>

    <div id="footer">
        <a url="www.reconfia.com">www.reconfia.com</a>
    </div>
</body>
</html>
