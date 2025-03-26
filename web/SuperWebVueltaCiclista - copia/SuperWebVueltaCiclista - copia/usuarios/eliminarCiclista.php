<?php

include_once "../persistence/MySQLPDO.class.php";
$id = $_POST['id'];
MySQLPDO::connect();
$borrado = MySQLPDO::eliminarCiclista($id);
if ($borrado != 0) {
    echo "Ciclista eliminado correctamente";
} else {
    echo "ERROR: no se ha podido eliminar el ciclista";
}