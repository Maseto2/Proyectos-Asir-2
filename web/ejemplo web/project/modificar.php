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
            <?php
            $id = $_GET["id"];

            echo $id;
            ?>
            </div>

        </div>
    </div>

</body>
</html>