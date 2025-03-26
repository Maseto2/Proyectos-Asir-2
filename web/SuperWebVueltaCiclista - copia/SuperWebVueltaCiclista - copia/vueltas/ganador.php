<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Ganador</title>
    <style>
        body {
    background-image: url("../img/ganador.jpg") ;
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
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
                <li><a href="../usuarios/homeusu.php" >HOME</a></li>
                <li><a href="../usuarios/participantes.php" >PARTICIPANTES</a></li>
                <li><a href="vueltas.php">VUELTAS</a></li>
              </ul>
        </div>
        <div class="enter">
            <form method="POST">
            <button type="submit" name="btn_cerrar">Cerrar sesi&oacute;n</button>
            </form>
            <?php
                 if (isset($_POST['btn_cerrar'])){
                    session_destroy();
                    header("location: ../usuarios/iniciarsesion.php");
                    }
            ?>
        </div>
    </div>
    <div class="ganador">
        <?php
            include_once "../persistence/MySQLPDO.class.php";
            $result = MySQLPDO::equipoGanador();
            /*if (sizeof($result) == 1) {
                ?>
                    <h1> El ganador es: </h1>
                <?php
                foreach ($result as $item) {
                    extract($item);
            }*/
            echo $result;
        ?>
            <!-- <p><?php //echo $NombreEquipo ?> con <?php //echo $NVuelta ?> vueltas</p> -->

            <?php
                // }
            ?>

    </div>
</body>
</html>