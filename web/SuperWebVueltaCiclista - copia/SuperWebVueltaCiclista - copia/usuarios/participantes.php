<!DOCTYPE html>
<html lang="en">
<head>

<style>
        body {
    background-image: url("../img/participantes.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Participantes</title>
</head>
<body>
<div class="cabecera">
        <div class="logo">
            <a href="index.html" class="logo">
                <img src="img/logazo.png" alt="Logo"/>
            </a>
        </div>
        <div class="indice">
            <ul>
                <li><a href="homeusu.php" >HOME</a></li>
                <li><a href="participantes.php" >PARTICIPANTES</a></li>
                <li><a href="../vueltas/vueltas.php">VUELTAS</a></li>
              </ul>
        </div>
        <div class="enter">
            <form method="POST">
            <button type="submit" name="btn_cerrar">Cerrar sesi&oacute;n</button>
            </form>
            <?php
                 if (isset($_POST['btn_cerrar'])){
                    session_destroy();
                    header("location: iniciarsesion.php");
                    }
            ?>
        </div>
    </div>
    <div id="formbuscadores">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <fieldset>
                <legend>Buscador de participantes</legend><br/>
                    <input type="text" name="nombre" placeholder="Nombre" required /><br/><br/>
                    <button type="submit" name="btn_buscar">Buscar</button>
            </fieldset>
        </form>
    </div>
    <?php
        session_start();
    ?>
        <div id="tabBuscador">
        <table>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Equipo</th>
                <?php if ($_SESSION['rol'] == 1) { ?><th>Eliminar</th> <?php } ?>
            </tr>
    <?php
        include_once "../persistence/MySQLPDO.class.php";
        include_once "../model/ciclista.class.php";

        if (isset($_POST['btn_buscar'])) {
            MySQLPDO::connect();
            $nombre_ciclista = $_POST['nombre'];
            $filaCiclista = MySQLPDO::buscarCiclista($nombre_ciclista);
            if (sizeof($filaCiclista) != 0) {
                foreach($filaCiclista as $item) {
                    extract($item);
                    ?>
            <tr>
                <td><?php if ($_SESSION['rol'] == 1) { ?><a href="modificarCiclista.php?id=<?php echo $id; ?>"> <?php } ?> <?php echo $id; ?> </td>
                <td><?php echo $nombre; ?></td>
                <td><?php echo $apellido; ?></td>
                <td><?php echo $usuario; ?></td>
                <td><?php echo $idequipo; ?></td>
                <?php if ($_SESSION['rol'] == 1) { ?> <td>
                    <form method="POST" action="eliminarCiclista.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" value="Borrar"/>
                    </form>
                </td> <?php } ?>
    	    </tr>
            <?php
            }
            ?>
                <?php
            } else {
                echo "No hay registros que mostrar";
            }
            ?>
        </table>
        </div>
        <?php
        } 

    ?>
</body>
</html>