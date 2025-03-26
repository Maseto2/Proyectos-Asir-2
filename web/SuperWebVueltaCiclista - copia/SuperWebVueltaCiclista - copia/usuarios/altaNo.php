<?php
include_once "../model/ciclista.class.php";
include_once "../persistence/MySQLPDO.class.php";

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$contra = $_POST['contra'];
$contrabbdd = md5($contra);
$mail = $_POST['mail'];
$equipo = $_POST['equipo'];


$objetoCiclista = new Ciclista();
$objetoCiclista -> setNombre($nombre);
$objetoCiclista -> setApellido($apellido);
$objetoCiclista -> setUsuario($usuario);
$objetoCiclista -> setContra($contrabbdd);
$objetoCiclista -> setMail($mail);
$objetoCiclista -> setIdequipo($equipo);

MySQLPDO::connect();
$result = MySQLPDO::insertarCiclista($objetoCiclista);
    if ($result != 0) {
        header("location: iniciarsesion.php");
        
    } else {
        echo "ERROR: No se ha podido introducir el ciclista";
    }
?>