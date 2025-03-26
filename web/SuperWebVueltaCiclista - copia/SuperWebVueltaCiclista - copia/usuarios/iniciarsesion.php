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
    <title>Iniciar sesión</title>
</head>
<body>
    <!-- Este es el formulario donde el usuario iniciará sesión -->
<div class="formulario">
<form method="post" action="homeusu.php">
            <fieldset>
                <legend>Inicio de sesi&oacute;n</legend><br/>
                    <!-- Se le pide que introduzca su nombre de usuario y su contraseña -->

                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required /><br/><br/>
                    <input type="password" name="contra" id="contra" placeholder="Contrase&ntilde;a" required /><br/><br/>
                    <button type="submit">Iniciar sesión</button><br/><br/><br/>
                    
                    <!-- En caso de no estar registrado puede pulsar el enlace que le llevará al formulario de registro -->
                    <a href="registro.php">¿Todav&iacute;a no est&aacute;s registrado?</a>
            </fieldset>
</form>
</div>
</body>
</html>