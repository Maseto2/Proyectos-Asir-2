<?php

include_once "../persistence/MySQLPDO.class.php";
$id = $_POST['id'];
MySQLPDO::connect();
$borrado = MySQLPDO::eliminarVuelta($id);
if ($borrado != 0) {
    echo "Vuelta eliminada correctamente";
} else {
    echo "ERROR: no se ha podido eliminar la vuelta";
}