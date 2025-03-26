<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
</head>
<body>
    <?php
    include_once  'persistence/MySQLPDO.class.php';
    
    if (isset($_POST['btn_borrar'])) {
        $varId = $_POST['id'];
        MySQLPDO::connect();
        $resultado = MySQLPDO::borrarExamen($varId);
        if ($resultado != 0) {
            echo "Examen borrado correctamente";
        } else {
            echo "ERROR: NO se pudo borrar el examen";
        }
 
    } else {
        echo "NO se recibio el Id";
    }

    ?>
</body>
</html>