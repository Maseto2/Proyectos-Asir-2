<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

        <input type="text" name="busqueda" >
        <input type="submit" value="Buscar" name="btn_buscar">

    </form>

    <?php 
    include_once 'persistence/MySQLPDO.class.php';

    if (isset($_POST['btn_buscar'])) {
        $busqueda = $_POST['busqueda'];
        MySQLPDO::connect();
        $aprobados = MySQLPDO::buscarAprobados($busqueda);
        if (!empty($aprobados)){
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Asignatura</th>
                    <th>Enunciado1</th>
                    <th>Puntuacion</th>
                    <th>Enunciado2</th>
                    <th>Puntuacion2</th>
                    <th>Aprobado</th>
                </tr>
                <?php
                foreach ($aprobados as $fila){
                    extract($fila);
                ?>
                <tr>
                    <td><a href="modificar.php?id=<?php echo $id ?>"><?php echo $id ?></a></td>
                    <td><?php echo $asignatura ?></td>
                    <td><?php echo $enunciado1 ?></td>
                    <td><?php echo $puntuacion1 ?></td>
                    <td><?php echo $enunciado2 ?></td>
                    <td><?php echo $puntuacion2 ?></td>
                    <td><?php echo $aprobado ?></td>
                    <td>
                        <form action="borrar.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="btn_borrar" value="Borrar">
                        </form>
                    </td>
                </tr>
                <?php
                }

                ?>
            </table>


            <?php
        }
    }

    ?>
</body>
</html>