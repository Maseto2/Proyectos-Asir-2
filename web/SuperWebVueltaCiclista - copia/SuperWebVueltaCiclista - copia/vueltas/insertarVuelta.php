<html>
    <head>
        <body>


<?php

    include_once "../model/vuelta.class.php";
    include_once "../persistence/MySQLPDO.class.php";

    if (isset($_POST['btn_enviar'])){
        $tiempo = $_REQUEST['result'];

        $objetoNumVuelta = new Vuelta();
        $objetoNumVuelta -> setIdciclista($idciclista);
        $objetoNumVuelta -> setFecha($fechaActual);

        $numVuelta = MySQLPDO::numeroVuelta($objetoNumVuelta) + 1;
        
        $objetoVuleta = new Vuelta();
        $objetoVuleta -> setIdciclista($idciclista);
        $objetoVuleta -> setTiempo($tiempo);
        $objetoVuleta -> setFecha($fechaActual);
        $objetoVuleta -> setNumVuelta($numVuelta);

        $resultado = MySQLPDO::insertarVuelta($objetoVuleta);
        if ($resultado != 0) {
            echo "Vuelta registrada correctamente";

        } else {
            echo "ERROR: No se ha podido registrar la vuelta";
        }

    }

?>

</body>
    </head>
</html>