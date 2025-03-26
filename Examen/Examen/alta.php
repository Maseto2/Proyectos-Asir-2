<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        Asignatura: <input type="text" maxlength="200" required="required" name="asignatura"><br>
        Enunciado1: <input type="text" maxlength="200" name="enunciado1"><br>
        Puntuacion1: <input type="number" min="1" max="10" step="0.01" name="puntuacion1"><br>
        Enunciado2: <input type="text" maxlength="200" name="enunciado2"><br>
        Puntuacion2: <input type="number" min="1" max="10" step="0.01" name="puntuacion2"><br>
        <input type="submit" value="Guardar" name="btn_alta">

    </form>
    <?php
    include_once 'persistence/MySQLPDO.class.php';
    include_once 'entity/Examen.class.php';
    if ( isset($_POST['btn_alta']) ) {

        $varAsignatura = $_POST['asignatura'];
        $varEnunciado1 = $_POST['enunciado1'];
        $varPuntuacion1 = $_POST['puntuacion1'];
        $varEnunciado2 = $_POST['enunciado2'];
        $varPuntuacion2 = $_POST['puntuacion2'];
        $varAprobado = null;

        $varPuntuacionFinal = ($varPuntuacion1 + $varPuntuacion2);
        if ($varPuntuacionFinal >= 5) {
            $varAprobado = "SI";
        } else {
            $varAprobado = "NO";
        }

        $objetoExamen = new Examen();
        $objetoExamen -> setAsignatura($varAsignatura);
        $objetoExamen -> setEnunciado1($varEnunciado1);
        $objetoExamen -> setPuntuacion1($varPuntuacion1);
        $objetoExamen -> setEnunciado2($varEnunciado2);
        $objetoExamen -> setPuntuacion2($varPuntuacion2);
        $objetoExamen -> setAprobado($varAprobado);

        MySQLPDO::connect();
        $resultado = MySQLPDO::insertarExamen($objetoExamen);
        if ($resultado != 0) {
            echo "Examen introducido correctamente";
        } else {
            echo "ERROR, NO se guardo el examen";
        }
    } else {
        echo "Rellene todos los campos";
    }
    ?>
</body>
</html>