<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    background-image: url("../img/velodromo.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Registro</title>
</head>
<body>
<div class="formulario">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <fieldset>
                <legend>Registro</legend><br/>
                <!-- Este es el formulario de registro, donde se le pedirán al usuario la siguiente información -->
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" required maxlength="200" /><br/><br/>
                    <input type="text" name="apellido" id="apellido" placeholder="Apellido" required maxlength="200" /><br/><br/>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required maxlength="200" /><br/><br/>
                    <!-- La contraseña se pide 2 veces para verificar que ha sido introducida correctamente -->
                    <input type="password" name="contra" id="contra" placeholder="Contrase&ntilde;a" required maxlength="200" /><br/><br/>
                    <input type="password" name="contra1" id="contra" placeholder="Contrase&ntilde;a" required maxlength="200" /><br/><br/>
                    <input type="mail" name="mail" id="mail" placeholder="mail" required maxlength="200" /><br/><br/>
                    <select name="rol" id="rol">
                    <?php
                        session_start();
                        include "../persistence/MySQLPDO.class.php";
                        include_once "../model/ciclista.class.php";
                        MySQLPDO::connect();

                        // Queremos que el usuario elija entre los dos roles que hay disponibles en a BBDD
                        // y así evitar que introduzca algo que no está contemplado.
                        $result = MySQLPDO::buscarRol();
                        foreach ($result as $item) {
                            extract($item);
                        ?>
                        
                        <option value="<?php echo $id ?>"><?php echo $nombre ?></option> 

                        <?php
                        }
                        // Se guarda el rol dentro de la variable global S_SESSION, para que este dato quede presente siempre y cuando la sesión quede abierta.
                        $_SESSION['rol'] = $_POST['rol'];
                        ?>
                    </select><br/><br/>
                    <select name="equipo" id="equipo">
                    <?php
                        // Lo mismo sucede con los equipos, solo queremos que pueda elegir entre los equipo previamente definidos.
                        $result = MySQLPDO::buscarEquipo();
                        foreach ($result as $item) {
                            extract($item);
                        ?>
                        
                        <option value="<?php echo $id ?>"><?php echo $nombre ?></option> 

                        <?php
                        }
                                                
                        ?>       
                        </select><br/><br/><br/>    
                    <button type="submit" name="btn_enviar">Registro</button><br/><br/>

                    <?php 

                    if (isset($_POST['btn_enviar'])) {
                        $contra = $_POST['contra'];
                        $contra1 = $_POST['contra1'];
                        if ($contra == $contra1) {

                            // Este método comprobará en la base de datos si el usuario introducido está duplicado o no.
                            // Es importante! Esta información se utilizará para iniciar sesión junto con una contraseña.
                            // Por lo que debe se único.
                            $repetido = MySQLPDO::buscarUsuario($usuario);
                            if(sizeof($repetido) == 0) {
                                $nombre = $_POST['nombre'];
                                $apellido = $_POST['apellido'];
                                $usuario = $_POST['usuario'];

                                // Por temas de seguridad la contraseña se encripta para enviarla a la BBDD
                                $contrabbdd = md5($contra);

                                $equipo = $_POST['equipo'];
                                $mail = $_POST['mail'];
                                

                                // Llenamos el objeto que se utilizará para introducir los datos en la tabla ciclista de la BBDD
                                $objetoCiclista = new Ciclista();
                                $objetoCiclista -> setNombre($nombre);
                                $objetoCiclista -> setApellido($apellido);
                                $objetoCiclista -> setUsuario($usuario);
                                $objetoCiclista -> setContra($contrabbdd);
                                $objetoCiclista -> setMail($mail);
                                $objetoCiclista -> setIdequipo($equipo);
                                $objetoCiclista -> setIdrol($_SESSION['rol']);
                                
                                // Los ciclistas se introducirá gracias a este método.
                                $result = MySQLPDO::insertarCiclista($objetoCiclista);
                                    if ($result != 0) {
                                        //En caso de que la inseción haya devuelto resultados se redirigirá al usuario al panel iniciar sesión.
                                        header("location: iniciarsesion.php");
                                        
                                    } else {
                                        echo "ERROR: No se ha podido introducir el ciclista";
                                    }
                                    
                                } else {
                                    echo "Usuario repetido";
                                }
                            } else {
                                echo "Las contraseñas no coinciden";
                            }
                        }
                    ?>
            </fieldset>
        </form>
</div>
</body>
</html>

