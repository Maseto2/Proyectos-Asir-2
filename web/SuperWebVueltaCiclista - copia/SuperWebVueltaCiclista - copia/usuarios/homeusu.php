<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/estilo.css" rel="stylesheet"/>
    <title>Home</title>
    <script src="../js/funciones.js"></script>
</head>
<body>

<?php
include_once "../persistence/MySQLPDO.class.php";
include_once "../model/ciclista.class.php";
include_once "../model/vuelta.class.php";
session_start();

MySQLPDO::connect();

if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $objetoVerifica = MySQLPDO::sacarUsuPass($id);
    if ($objetoVerifica != null) {
        $usuario = $objetoVerifica -> getUsuario();
        $contrabd = $objetoVerifica -> getContra();
    }
} else {

$usuario = $_POST['usuario'];
$contra = $_POST['contra'];
$contrabd = md5($contra);

$objetoVerifica = new Ciclista;
$objetoVerifica -> setUsuario($usuario);
$objetoVerifica -> setContra($contrabd);

}


$objetoCiclista = MySQLPDO::Verificar($objetoVerifica);
    if ($objetoCiclista != null) {
        $_SESSION['id'] = $objetoCiclista -> getId();
        $idequipo = $objetoCiclista -> getIdequipo();
        $nombre = $objetoCiclista ->getNombre();
        $_SESSION['rol'] = $objetoCiclista -> getIdrol();
?>

<div class="cabecera">
        <div class="logo">
            <a href="index.html" class="logo">
                <img src="img/logazo.png" alt="Logo"/>
            </a>
        </div>
        <div class="indice">
            <ul>
                <li><a href="homeusu.php" >HOME</a></li>
                <li><a href="participantes.php" >PARTICIPANTES</a></li>
                <li><a href="../vueltas/vueltas.php">VUELTAS</a></li>
              </ul>
        </div>
        <div class="enter">
            <form method="POST">
            <button type="submit" name="btn_cerrar">Cerrar sesi&oacute;n</button>
            </form>
            <?php
                 if (isset($_POST['btn_cerrar'])){
                    session_destroy();
                    header("location: iniciarsesion.php");
                    }
            ?>
        </div>
    </div>

    <!-- <div class="cabecera"> 
        <div class="panel"><h1>Bienvenido <?php echo $nombre ?> </h1></div>
        <div class="botoncabecera"><button type="submit">Cerrar sesi&oacute;n</button></div>
    </div>-->
    <div class="nav">
    <img src="../img/berriz.jpg" alt="Velodromo de Berriz">
    <p>Este d&iacute;a en el vel&oacute;dromo de Berriz habr&aacute; una competici&oacute;n ciclista</p>
    <div id="ganador">
    <form action="../vueltas/ganador.php">
        <button type="submit">¡Ganador!</button>
    </form>
    </div>
    </div>

        <div class="imagenes">
        <div id="inicio">       
        <form action="" method="POST">
        <p>Inicio de vuelta</p>
        <!--<input name="btn_inicio" type="image" src="../img/iniciovuelta.jpg" width="75%" height="75%"/> -->
        <button type="submit" name="btn_inicio">Empezar</button>
        <!-- <input type="hidden" name="usuario" value="<?php echo $usuario ?>"/> -->
        <!-- <input type="hidden" name="contra" value="<?php echo $contra ?>"/> -->
        </form>
        </div>
        <div id="fin">
        <form action="" method="POST">
        <p>Fin de vuelta</p>
        <!--<input name="btn_enviar" type="image" src="../img/finvuelta5.jpg" width="75%" height="75%"/>-->
        <button type="submit" name="btn_fin"> Detener </button>
        <!-- <input type="hidden" name="usuario" value="<?php echo $usuario ?>"/> -->
        <!-- <input type="hidden" name="contra" value="<?php echo $contra ?>"/> -->
        </form>
        </div>
        <div class="participantes">
        <p>Participantes</p>
        <a href="participantes.php"><img src="../img/participantes.jpg" alt="URL participantes"></a>
        </div>
        <div class="vueltas">
        <p>Vueltas</p>
        <a href="../vueltas/vueltas.php"><img src="../img/cronociclista.jpg" alt="URL vueltas"></a>
        </div>
        </div>
        <p id="crono" name="crono"></p>

        <p><?php $fechaActual = date('Y-m-d'); 
        echo $fechaActual; ?></p>

        <?php
        
            if (isset($_POST['btn_inicio'])){
                //$tiempo = $_GET['result'];
                $tiempo= time();
                

                $objetoNumVuelta = new Vuelta();
                $objetoNumVuelta -> setIdciclista($_SESSION['id']);
                $objetoNumVuelta -> setFecha($fechaActual);
        
                $numVuelta = MySQLPDO::numeroVuelta($objetoNumVuelta) + 1;
                
                $objetoInicio = new Vuelta();
                $objetoInicio -> setIdciclista($_SESSION['id']);
                $objetoInicio -> setTiempo($tiempo);
                $objetoInicio -> setFecha($fechaActual);
                $objetoInicio -> setNumVuelta($numVuelta);
        
                $resultado = MySQLPDO::inicioVuelta($objetoInicio);
                if ($resultado != 0) {
                    echo "Vuelta registrada correctamente";
        
                } else {
                    echo "ERROR: No se ha podido registrar la vuelta";
                }
        
            }

            if (isset($_POST['btn_fin'])){
                $tiempo= time();
                

                $objetoNumVuelta = new Vuelta();
                $objetoNumVuelta -> setIdciclista($_SESSION['id']);
                $objetoNumVuelta -> setFecha($fechaActual);
        
                $numVuelta = MySQLPDO::numeroVuelta($objetoNumVuelta);

                $objetoFin = new Vuelta();
                $objetoFin -> setIdciclista($_SESSION['id']);
                $objetoFin -> setNumVuelta($numVuelta);
                $objetoFin -> setTiempo($tiempo);
                $objetoFin -> setFecha($fechaActual);

                $resultado = MySQLPDO::finvuelta($objetoFin);

                $tiempoMax = MySQLPDO::contadorTiempo($idequipo);
                if ($tiempoMax >= 600) {
                    echo "Te has pasado de tiempo, esta vuelta no cuenta";
                    $pasadoTiempo = MySQLPDO::BorrarUltVuelta(); //TODO: trigger cuando se borre esta vuelta que la almacene en otra tabla
                    if ($pasadoTiempo != 0) {
                        echo "Vuelta eliminada";
                    }
                    
                }
            }

    } else {
        echo "ERROR: el usuario o la contraseña no son correctos";
    }

    if (isset($_POST['btn_cerrar'])){
        session_destroy();
        header("location: iniciarsesion.php");
    }


?>
</body>
</html>