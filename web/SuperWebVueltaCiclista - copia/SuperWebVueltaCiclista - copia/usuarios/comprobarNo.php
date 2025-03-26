<?php
include_once "../persistence/MySQLPDO.class.php";
include_once "../model/ciclista.class.php";

$usuario = $_POST['usuario'];
$contra = $_POST['contra'];
$contrabd = md5($contra);

$objetoVerifica = new Ciclista;
$objetoVerifica -> setUsuario($usuario);
$objetoVerifica -> setContra($contrabd);

MySQLPDO::connect();
$objetoId = MySQLPDO::Verificar($objetoVerifica);
    if ($objetoId != null) {
        echo "Usuario y contraseña correctos";
        $id = $objetoId -> getId();
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
<?php
        header("location: homeusu.php?id=$id");
        
    } else {
        echo "ERROR: el usuario o la contraseña no son correctos";
    }
?>