<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificado</title>
</head>
<body>
    <?php
    include 'entity/Examen.class.php';
    include 'persistence/MySQLPDO.class.php';

    if (isset($_POST['btn_modificar'])) {
        $varId = $_POST['id'];
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
        $objetoExamen -> setId($varId);
        $objetoExamen -> setAsignatura($varAsignatura);
        $objetoExamen -> setEnunciado1($varEnunciado1);
        $objetoExamen -> setPuntuacion1($varPuntuacion1);
        $objetoExamen -> setEnunciado2($varEnunciado2);
        $objetoExamen -> setPuntuacion2($varPuntuacion2);
        

        MySQLPDO::connect();
        $resultado = MySQLPDO::modificarExamen($objetoExamen);
        if ($resultado != 0 ) {
            echo "Examen modificado correctamente";
        } else {
            echo "Error , no se pudo modificar el examen";
        }
    }
    ?>
</body>
</html>