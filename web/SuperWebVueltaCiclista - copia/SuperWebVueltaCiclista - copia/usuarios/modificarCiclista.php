<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Modificar</title>
    <style>
        body {
    background-image: url("../img/participantes.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
</head>
<body>
    <?php
        include_once "../persistence/MySQLPDO.class.php";
        include_once "../model/ciclista.class.php";

        if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else if (isset($_POST['id'])){
                $id = $_POST['id'];
            } else {
                die("ERROR: No se ha podido recuperar la id");
        }

        MySQLPDO::connect();
        if (isset($_POST['btn_modificar'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $usuario = $_POST['usuario'];
            $mail = $_POST['mail'];
            $idequipo = $_POST['idequipo'];

            $objetoCiclista = new Ciclista();
            $objetoCiclista -> setId($id);
            $objetoCiclista -> setNombre($nombre);
            $objetoCiclista -> setApellido($apellido);
            $objetoCiclista -> setUsuario($usuario);
            $objetoCiclista -> setMail($mail);
            $objetoCiclista -> setIdequipo($idequipo);

            $resultado = MySQLPDO::modificarCiclista($objetoCiclista);
            if ($resultado != 0) {
                echo "Ciclista modificada corectamente";
            } else {
                echo "No se ha podido modificar el ciclista";
            }

        }

        $objetoCiclista = MySQLPDO::obtenerCiclista($id);
        if ($objetoCiclista == null) {
            die ("ERROR: No existe ningún ciclista con ese id.");
        } else {


    ?>
    <div id="formbuscadores">

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <legend>Modificar ciclista</legend>
        <input type="hidden" name="id" value="<?php echo $id ?>"/>
        <label for="nombre">Nombre:</label>
            <input type="text" value="<?php echo $objetoCiclista -> getNombre() ?>" name="nombre"/>
        <label for="apellido">Apellido:</label>
            <input type="text" value="<?php echo $objetoCiclista -> getApellido() ?>" name="apellido"/>
        <label for="usuario">Usuario:</label>
            <input type="text" value="<?php echo $objetoCiclista -> getUsuario() ?>" name="usuario"/>
        <label for="mail">Email:</label>
            <input type="mail" value="<?php echo $objetoCiclista -> getMail() ?>" name="mail"/>
        <label for="idequipo">Equipo:</label>
            <input type="number" value="<?php echo $objetoCiclista -> getIdequipo() ?>" name="idequipo">
        <button type="submit" name="btn_modificar">Modificar</button>
    </form>
    </div>
    <?php 
        }
    ?>
</body>
</html>