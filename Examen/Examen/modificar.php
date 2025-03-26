<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar examen</title>
</head>
<body>
    <?php

    include 'entity/Examen.class.php';
    include 'persistence/MySQLPDO.class.php';

    if (!isset($_GET['id'])){
        die ('ERROR: NO se recibio el Id');
    } else  {
        $varId = $_GET['id'];
        MySQLPDO::connect();
        $objetoExamen = MySQLPDO::selectExamen($varId);
    }
    ?>
    <form action="modificado.php" method="post">
        <input type="text" name="id" value="<?php echo $objetoExamen -> getId() ; ?>"    readonly> <br>
        Asignatura: <input type="text" maxlength="200" required="required" name="asignatura" value="<?php echo $objetoExamen -> getAsignatura() ; ?>" required="required"><br>
        Enunciado1: <input type="text" maxlength="200" name="enunciado1" value="<?php echo $objetoExamen -> getEnunciado1(); ?>" required="required"><br>
        Puntuacion1: <input type="number" min="1" max="10" step="0.01" name="puntuacion1" value="<?php echo $objetoExamen -> getPuntuacion1(); ?>" required="required"><br>
        Enunciado2: <input type="text" maxlength="200" name="enunciado2"value="<?php echo $objetoExamen -> getEnunciado2(); ?>"  required="required"><br>
        Puntuacion2: <input type="number" min="1" max="10" step="0.01" name="puntuacion2" value="<?php echo $objetoExamen -> getPuntuacion2(); ?>"  required="required"><br>
        APROBADO: <input type="text" name="aprobado" value="<?php echo $objetoExamen -> getAprobado() ?>" readonly>
        <input type="submit" value="Modificar" name="btn_modificar">
    </form>
</body>
</html>