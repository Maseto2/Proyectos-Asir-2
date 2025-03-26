<?php
class MySQLPDO {
    private static $host = "localhost"; //o la IP del servidor de BBBDD remoto
    private static $database = "velodromo";
    private static $username = "root";
    private static $password = "1234";
    private static $base;
    
    public static function connect() {
        if (MySQLPDO::$base != null) {
            MySQLPDO::$base = null;
        }
        try {
            $dsn = "mysql:host=" . MySQLPDO::$host . ";dbname=" . MySQLPDO::$database;
            MySQLPDO::$base = new PDO($dsn, MySQLPDO::$username, MySQLPDO::$password);
            MySQLPDO::$base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return MySQLPDO::$base;
        } catch (Exception $e) {
            die ("Error connecting: {$e->getMessage()}");
        }
    }
    
    //ejecuta sentencias INSERT, UPDATE y DELETE
    public static function exec($sql, $params) {
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->rowCount();
        return $result; //devuelve el n� de filas afectadas por la sentencia
    }
    
    //ejecuta sentencias SELECT
    public static function select($sql, $params) {
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result; //devuelve el conjunto de datos de la consulta
    }
        //Comprueba si el usuario elegido está en la bbdd
        public static function buscarUsuario($user){
            $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
            $params = array($user);
            $result = MySQLPDO::select($sql, $params);
            return $result;
        }
        public static function insertarUsuario($objusuario) {
            $sql = "INSERT INTO usuario (nombre, apellido, nombre_usuario, contrasena, mail, id_rol) VALUES (?, ?, ?, ?, ?, ?)";
            $params = array( 
            $objusuario -> getNombre(), 
            $objusuario -> getApellido(), 
            $objusuario -> getUser(), 
            $objusuario -> getContrasena(), 
            $objusuario -> getMail(),
            $objusuario -> getrol()
            );
            $result = MySQLPDO::exec($sql, $params);
            return  $result;
        }
    public static function sacarUsuario($id) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $params = array($id);
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0){
            return null;
        } else {
            extract($result[0]);
            $objverificar = new usuario();
            $objverificar -> setNombre($nombre);
            $objverificar -> setUser($nombre_usuario);
            $objverificar -> setContrasena($contrasena);
            $objverificar -> setApellido($apellido);
            $objverificar -> setMail($mail);
            $objverificar -> setRol($id_rol);
            return $objverificar;
        }
    }
    public static function Verificar($objverificar) {
        $sql = "SELECT * FROM usuario where nombre_usuario = ? and contrasena = ?";
        $params = array($objverificar -> getUser(), $objverificar -> getContrasena());
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0) {
            return null;   
        } else {
            extract($result[0]);
            $objusuario = new usuario();
            $objusuario -> setId($id);
            $objusuario -> setNombre($nombre);
            return $objusuario;
        }
        
}
    public static function cambiarRol($id, $nuevoRol) {
        $sql = "UPDATE usuario SET id_rol = ? WHERE id = ?";
        $params = array($nuevoRol, $id);
        return MySQLPDO::exec($sql, $params);
}
    public static function obtenerAdminPass() {
        $sql = "SELECT pass from rol where id = 1";
        $params = array();
    }
    public static function sacartodoslosusuarios() {
        $sql ="SELECT usuario.id, nombre, apellido, mail, nombre_usuario, rol.rol FROM USUARIO  INNER JOIN rol on usuario.id_rol = rol.id";
        $params = array();
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }
    public static function nombrequipo() {
        $sql ="SELECT id, nombre FROM equipo";
        $params = array();
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }
    public static function UnirUsuarioEquipo($idusuario, $idequipo) {
        try {
            $sql = "INSERT INTO ciclista (id_usuario, id_equipo) VALUES (?, ?)";
            $params = array($idusuario, $idequipo);
            $resultado = MySQLPDO::exec($sql, $params);
            return $resultado;
        } catch (PDOException $e) {
            // Manejar la excepción de violación de integridad aquí
            $errorCode = $e->getCode();
            if ($errorCode == '23000') {
                // Código de error 23000 es para violación de integridad (clave duplicada, etc.)
                // Aquí puedes verificar el mensaje de la excepción para determinar qué restricción se violó
                $errorMessage = $e->getMessage();
                
                // Verificar si el error específico es para la clave única 'ciclista.unique_usuario'
                if (strpos($errorMessage, 'ciclista.unique_usuario') !== false) {
                    // El usuario ya está en este equipo
                    echo '<script>';
                                echo 'Swal.fire({
                                    text: "Error: El usuario ya está en el equipo",
                                    }
                                });';
                                echo '</script>';
                } else {
                    // Otro tipo de violación de integridad
                    echo "Error de integridad: " . $errorMessage;
                }
            } else {
                // Otro tipo de excepción de PDO
                echo "Error de PDO: " . $e->getMessage();
            }
        }
    }
    
}   
?>