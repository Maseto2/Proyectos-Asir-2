<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
                body {
    background-image: url("../img/cronociclista.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
</head>
<body>
    <?php
        include_once "../persistence/MySQLPDO.class.php";
        include_once "../model/vuelta.class.php";
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
            /*$nombre = $_POST['nombre'];
            $apellido = $_POST['apellido']; */
            $idciclista = $_POST['id'];
            $tiempo = $_POST['tiempo'];
            $fecha = $_POST['fecha'];
            $numVuelta = $_POST['numVuelta'];


            $objetoVuelta = new Vuelta();
            $objetoVuelta -> setId($id);
            $objetoVuelta -> setIdciclista($idciclista);
            $objetoVuelta -> setTiempo($tiempo);
            $objetoVuelta -> setFecha($fecha);
            $objetoVuelta -> setNumVuelta($numVuelta);

            $resultado = MySQLPDO::modificarVuelta($objetoVuelta);
            if ($resultado != 0) {
                echo "Vuelta modificada corectamente";
            } else {
                echo "No se ha podido modificar la vuelta";
            }

        }

        $objetoVuelta = MySQLPDO::obtenerVuelta($id);
        if ($objetoVuelta == null) {
            die ("ERROR: No existe ninguna vuelta con ese id.");
        } else {

            /*$idCicli = $objetoVuelta -> getIdciclista();
            $objetoCiclista = MySQLPDO::nomApel($idCicli);
            echo $objetoCiclista -> getNombre();*/



    ?>
    <div id="formbuscadores">

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <legend>Modificar vuelta:</legend><br/>
        <input type="hidden" name="id" value="<?php echo $id ?>"/>
        <label for="nombre">Id ciclista:</label>
            <input type="text" value="<?php echo $objetoVuelta -> getIdciclista() ?>" name="nombre"/><br/><br/>
        <label for="usuario">Tiempo:</label>
            <input type="text" value="<?php echo $objetoVuelta -> getTiempo() ?>" name="tiempo"/><br/><br/>
        <label for="mail">Fecha:</label>
            <input type="mail" value="<?php echo $objetoVuelta -> getFecha() ?>" name="fecha"/><br/><br/>
        <label for="idequipo">Vueltas:</label>
            <input type="number" value="<?php echo $objetoVuelta -> getNumVuelta() ?>" name="numVuelta"><br/><br/>
        <button type="submit" name="btn_modificar">Modificar</button>
    </form>
    </div>
    <?php 
        }
    ?>
</body>
</html>