<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="../styles/style_home.css">
</head>
<body>
<?php

include_once '../entity/usuario.class.php';
include_once '../persistence/MySQLPDO.class.php';

MySQLPDO::connect();

// Variables para evitar errores de "undefined"
$apellido = "";
$mail = "";
$rolactual = "";
$idrol = "";

// Verificar si la sesión está iniciada
if (empty($_SESSION['id'])){
    echo '<script>';
    echo 'Swal.fire({
        text: "Bienvenido!",
        onClose: () => {
            window.location.href = "home_usuario.php";
        }
    });';
    echo '</script>';
}

if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $objverificar = MySQLPDO::sacarUsuario($id);

    if ($objverificar != null) {
        $usuario = $objverificar->getUser();
        $contracif = $objverificar->getContrasena();
        $apellido = $objverificar->getApellido();
        $mail = $objverificar->getMail();
        $idrol = $objverificar->getRol();

        // Determinar el rol del usuario de manera más clara
        $rolactual = ($idrol == 2) ? "Usuario" : (($idrol == 1) ? "Administrador" : "Desconocido");
    }
} else {
    $user = $_POST['user'];
    $contrasena = $_POST['contrasena'];
    $contracif = md5($contrasena);

    $objverificar = new usuario;
    $objverificar->setUser($user);
    $objverificar->setContrasena($contracif);
}

$objetousuario = MySQLPDO::Verificar($objverificar);

if ($objetousuario != null) {
    $_SESSION['id'] = $objetousuario->getId();
    $idequipo = $objetousuario->getEquipo();
    $nombre = $objetousuario->getNombre();

    // Mostrar la página
    ?>
    <div id="container">
        <div id="sidebar">
            <img id="sidebar-logo" src="../img/logo.png" alt="Logo">
            <nav id="sidebar-menu">
                <ul>
                    <li><a href="home_usuario.php">HOME</a></li>
                    <li><a href="registrar_equipo.php">Registrar Equipo</a></li>
                    <li><a href="vueltas.php">Vueltas</a></li>
                    <li><a href="carreras.php">Carreras</a></li>
                    <li>
                        <div class="enter">
                            <form method="POST">
                                <button type="submit" name="btn_cerrar">Cerrar sesión</button>
                            </form>
                            <?php
                            if (isset($_POST['btn_cerrar'])) {
                                session_destroy();
                                header("location: iniciar_sesion.php");
                            }
                            ?>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="content">
            <div id="user-section">
                <h1 id="user-name"> <?php echo "Nombre: ", isset($nombre) ? $nombre : ''; ?></h1>
                </br>
                <h2 id="Apellido"><?php echo "Apellido: ",isset($apellido) ? $apellido : ''; ?></h2>
                </br>
                <h2 id="Mail"><?php echo "Correo Electrónico: ", isset($mail) ? $mail : ''; ?></h2>
                </br>
                <h2 id="Mail"><?php echo "Cuenta de ", isset($rolactual) ? $rolactual : ''; ?></h2>
            </div>

            <?php
            // Mostrar la tabla de los equipos solo si el usuario es usuario (no administrador)
            if ($idrol == 2) {
                $nombrequipo = MySQLPDO::nombrequipo(); // Sacar los equipos disponibles

                if (sizeof($nombrequipo) != 0) {
                    echo '
                        <table border="1" id="home-table">
                            <thead>
                                <tr>
                                    <th colspan="3">Equipos</th>
                                </tr>
                                <tr>
                                    <th>Número de equipo</th>
                                    <th>Nombre del equipo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                    ';

                    foreach ($nombrequipo as $equipos) {
                        // Crea variables de forma automática con EL MISMO nombre que las COLUMNAS de BD
                        extract($equipos);
                        echo '
                            <tr>
                                <td>' . $id .  '</td>
                                <td>' . $nombre . '</td>
                                <td>
                                    <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
                                        <input type="hidden" name="action" value="unirUsuario">
                                        <input type="hidden" name="id_equipo" value="' . $id . '">
                                        <input type="submit" value="Unirse">
                                    </form>
                                </td>
                            </tr>
                        ';
                    }

                    echo '</tbody></table>';

                    // Procesar la solicitud de unirse a un equipo
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'unirUsuario' && isset($_POST['id_equipo'])) {
                        // Asegúrate de que el usuario esté autenticado y tiene permisos adecuados antes de realizar la unión

                        $idEquipo = $_POST['id_equipo'];

                        // Utiliza el ID del usuario almacenado en la sesión
                        $idUsuario = $_SESSION['id'];

                        // Llamar a la función para unir el usuario al equipo
                        $resultado = MySQLPDO::unirUsuarioEquipo($idUsuario, $idEquipo);

                        // Redirige para evitar la reenviación al recargar la página
                        header("Location: {$_SERVER['PHP_SELF']}");

                        // Muestra la alerta solo si la redirección no se ejecuta
                        if ($resultado !== null) {
                            echo '<script>';
                            echo 'Swal.fire({
                                text: "Usuario añadido al equipo exitosamente",
                            });';
                            echo '</script>';
                        }
                    }
                }
                ?>
                <form method="POST" action="$_SERVER['PHP_SELF']" id="admin-form">
                    <label for="password_admin">Ascender a cuenta de administrador:</label>
                    <input type="password" id="password_admin" name="password_admin" required>
                    <button type="submit" name="btn_admin" class="button">Convertirse en Administrador</button>
                </form>
                <?php
                // Procesar la solicitud de convertirse en administrador
                    if (isset($_POST['btn_admin'])) {
                    $password_admin = $_POST['password_admin'];

                     // Verificar la contraseña de administrador
                     if ($password_admin == "410113") {
                     // Cambiar el rol a Administrador
                        MySQLPDO::cambiarRol($id, 1);
                        $_SESSION['rol'] = 1; // Actualizamos el rol en la sesión
                    header("Refresh:0"); // Recarga la página para reflejar el cambio
                } else {
                    echo '<p>Contraseña de administrador incorrecta</p>';
                }
            }

            }

            // Mostrar la sección de administradores solo si el usuario es administrador
            if ($rolactual == "Administrador") {
                $usuarios = MySQLPDO::sacartodoslosusuarios(); // Supongamos que hay una función buscarUsuarios() para obtener la información de los usuarios

                if (sizeof($usuarios) != 0) {
                    echo '
                        <table border="1" id="home-table">
                            <thead>
                                <tr>
                                    <th colspan="7">Usuarios</th>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                    ';

                    // Para cada uno de los usuarios devueltos
                    foreach ($usuarios as $usuario) {
                        // Crea variables de forma automática con EL MISMO nombre que las COLUMNAS de BD
                        extract($usuario);
                        echo '
                            <tr>
                                <td>' . $nombre . '</td>
                                <td>' . $apellido . '</td>
                                <td>' . $mail . '</td>
                                <td>' . $nombre_usuario . '</td>
                                <td>' . $rol . '</td>
                                <td><button class="button tabla" onclick="window.location.href=\'modificar.php?id=' . $id . '\'">Modificar</button></td>
                                <td><button class="button tabla" onclick="window.location.href=\'borrar.php?id=' . $id . '\'">Borrar</button></td>
                            </tr>
                        ';
                    }

                    echo '</tbody></table>';
                }
            }
            ?>

        </div>
    </div>

    <?php
} else {
    echo '<script>';
    echo 'Swal.fire({
        text: "Las credenciales no son válidas, inténtalo de nuevo o regístrate",
        onClose: () => {
            window.location.href = "iniciar_sesion.php";
        }
    });';
    echo '</script>';
}
?>
</body>
</html>