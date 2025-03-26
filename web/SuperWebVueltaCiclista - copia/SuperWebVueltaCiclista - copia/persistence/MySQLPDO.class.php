<?php
class MySQLPDO {
    private static $host = "localhost"; //o la IP del servidor de BBBDD remoto
    private static $database = "velodromo";
    private static $username = "root";
    private static $password = "root";
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
        return $result; //devuelve el nº de filas afectadas por la sentencia
    }
    
    //ejecuta sentencias SELECT
    public static function select($sql, $params) {
        $stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        return $result; //devuelve el conjunto de datos de la consulta
    }

    //Comprueba si el usuario elegido está en la bbdd
    public static function buscarUsuario($usuario){
        $sql = "SELECT * FROM ciclista WHERE usuario like ?";
        $params = array($usuario);
        $result = MySQLPDO::select($sql, $params);
        return $result;
    }

    public static function buscarEquipo() {
        $sql = "SELECT id, nombre FROM equipo";
        $params = array();
        $result = MySQLPDO::select($sql, $params);
        return $result;
    }

    public static function buscarRol() {
        $sql = "SELECT id, nombre FROM rol";
        $params = array();
        $result = MySQLPDO::select($sql, $params);
        return $result;
    }

    public static function insertarCiclista($objetoCiclista) {
        $sql = "INSERT INTO ciclista (nombre, apellido, usuario, contra, mail, idequipo, idrol) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array($objetoCiclista -> getNombre(), $objetoCiclista -> getApellido(), $objetoCiclista -> getUsuario(), $objetoCiclista -> getContra(), $objetoCiclista -> getMail(), $objetoCiclista -> getIdequipo(), $objetoCiclista -> getIdrol());
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function Verificar($objetoVerifica) {
        $sql = "SELECT * FROM ciclista where usuario = ? and contra = ?";
        $params = array($objetoVerifica -> getUsuario(), $objetoVerifica -> getContra());
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0) {
            return null;   
        } else {
            extract($result[0]);
            $objetoCiclista = new Ciclista();
            $objetoCiclista -> setId($id);
            $objetoCiclista -> setNombre($nombre);
            $objetoCiclista -> setIdequipo($idequipo);
            $objetoCiclista -> setIdrol($idrol);
            return $objetoCiclista;
        }

    }

    public static function sacarUsuPass($id) {
        $sql = "SELECT usuario, contra FROM ciclista WHERE id = ?";
        $params = array($id);
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0){
            return null;
        } else {
            extract($result[0]);
            $objetoVerifica = new Ciclista();
            $objetoVerifica -> setUsuario($usuario);
            $objetoVerifica -> setContra($contra);
            return $objetoVerifica;
        }
    }

    public static function insertarVuelta($objetoVuelta) {
        $sql = "INSERT INTO vuelta (idciclista, tiempo, fecha, numVuelta) VALUES (?, ?, ?, ?)";
        $params = array($objetoVuelta -> getIdciclista(), $objetoVuelta -> getTiempo(), $objetoVuelta -> getFecha(), $objetoVuelta -> getNumVuelta());
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function numeroVuelta($objetoNumVuelta) {
        $sql = "SELECT * FROM vuelta WHERE idciclista = ? and fecha = ?";
        $params = Array($objetoNumVuelta -> getIdciclista(),$objetoNumVuelta -> getFecha());
        $result = MySQLPDO::select($sql, $params);
        if ($result == null){
            return 0;
        } else{
        return sizeof($result);
        }
    }

    public static function inicioVuelta($objetoInicio) {
        $sql = "INSERT INTO vuelta (idciclista, tiempo, fecha, numVuelta) VALUES (?, ?, ?, ?)";
        $params = array($objetoInicio -> getIdciclista(), $objetoInicio -> getTiempo(), $objetoInicio -> getFecha(), $objetoInicio -> getNumVuelta());
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function finvuelta($objetoFin){
        $sql = "UPDATE vuelta set tiempo = (? -(select tiempo from (SELECT tiempo FROM vuelta where idciclista = ? and numVuelta = ? and fecha = ?) as tiempo)) where idciclista = ? and numVuelta = ? and fecha = ?;";
        $params = array($objetoFin -> getTiempo(), $objetoFin -> getIdciclista(), $objetoFin -> getNumVuelta(), $objetoFin -> getFecha(), $objetoFin -> getIdciclista(), $objetoFin -> getNumVuelta(), $objetoFin -> getFecha());
        $result = MySQLPDO::exec($sql,$params);
        return $result;
    }

    public static function buscarCiclista($nombre_ciclista){
        $sql = "SELECT * FROM ciclista WHERE nombre LIKE ?";
        $params = array("%" . $nombre_ciclista . "%");
        $result = MySQLPDO::select($sql, $params);
        return $result;
    }

    public static function obtenerCiclista($id) {
        $sql = "SELECT * FROM ciclista WHERE id = ?";
        $params = array($id);
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0) {
            return null;
        } else {
            extract($result[0]);
            $objetoCiclista = new Ciclista();
            $objetoCiclista -> setId($id);
            $objetoCiclista -> setNombre($nombre);
            $objetoCiclista -> setApellido($apellido);
            $objetoCiclista -> setUsuario($usuario);
            $objetoCiclista -> setContra($contra);
            $objetoCiclista -> setMail($mail);
            $objetoCiclista -> setIdequipo($idequipo);
            return $objetoCiclista;
        }
    }

    public static function modificarCiclista($objetoCiclista) {
        $sql="UPDATE ciclista SET nombre = ?, apellido = ?, usuario = ?, mail = ?, idequipo = ? WHERE id = ?";
        $params = array($objetoCiclista -> getNombre(), $objetoCiclista -> getApellido(), $objetoCiclista -> getUsuario(), $objetoCiclista -> getMail(), $objetoCiclista -> getIdequipo(), $objetoCiclista -> getId());
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function eliminarCiclista($id) {
        $sql = "DELETE FROM ciclista WHERE id = ?";
        $params = array($id);
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function buscarVuelta($nombre_ciclista) {
        $sql = "SELECT v.id, c.nombre, c.apellido, v.tiempo, v.fecha, v.numvuelta FROM vuelta v inner join ciclista c on v.idciclista=c.id WHERE c.nombre like ?";
        $params = array("%" . $nombre_ciclista . "%");
        $result = MySQLPDO::select($sql, $params);
        return $result;
    }

    /* public static function obtenerIdCiclista($objetoCiclista) {
        $sql = "SELECT id FROM ciclista WHERE nombre like ? and apellido like ?";
        $params = array($objetoCiclista -> getNombre(), $objetoCiclista -> getApellido());
        $result = MySQLPDO::select($sql, $params);
        return $result;
        } */

    public static function obtenerVuelta($id) {
        $sql = "SELECT * FROM vuelta v inner join ciclista c on v.idciclista=c.id WHERE v.id = ?";
        $params = array($id);
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0) {
            return null;
        } else {
            extract($result[0]);
            $objetoVuelta = new Vuelta();
            $objetoVuelta -> setId($id);
            $objetoVuelta -> setIdciclista($idciclista);
            $objetoVuelta -> setTiempo($tiempo);
            $objetoVuelta -> setFecha($fecha);
            $objetoVuelta -> setNumVuelta($numvuelta);
            return $objetoVuelta;
        }
        
    }

    /*public static function nomApel($idCicli) {
        $sql = "SELECT nombre, apellido from ciclista where id = ?";
        $params = array($idCicli);
        $result = MySQLPDO::select($sql, $params);
        if (sizeof($result) == 0) {
            return null;
        } else {
            extract($result[0]);
            $objetoCiclista = new Ciclista();
            $objetoCiclista -> setNombre($nombre);
            $objetoCiclista -> setApellido($apellido);
            return $objetoCiclista;
        }
    }*/

    public static function modificarVuelta($objetoVuelta) {
        $sql="UPDATE vuelta SET idciclista = ?, tiempo = ?, fecha = ?, numVuelta = ? WHERE id = ?";
        $params = array($objetoVuelta -> getIdciclista(), $objetoVuelta -> getTiempo(), $objetoVuelta -> getFecha(), $objetoVuelta -> getNumVuelta(), $objetoVuelta -> getId());
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    public static function eliminarVuelta($id) {
        $sql = "DELETE FROM vuelta WHERE id = ?";
        $params = array($id);
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    }

    // CON ESTA FUNCION CONSEGUIMOS EL TIEMPO QUE LLEVA UN GRUPO CORRIENDO
    public static function contadorTiempo($idequipo) {
        // ES IMPORTANTE PONERLE UN ALIAS A LA FUNCION DE MYSQL PARA PODER LLAMARLA
        $sql = "SELECT tiempoMax(?) as tiempoMax";
        $params = array($idequipo);
        $result = MySQLPDO::select($sql, $params);
        // HACEMOS UN EXTRACT PARA PODER METER EL VALOR EN UNA VARIABLE
        extract($result[0]);
        return $tiempoMax;
    }

    public static function BorrarUltVuelta() {
        $sql = "DELETE FROM vuelta WHERE id = (SELECT MAX(id) FROM vuelta)";
        $params = array();
        $result = MySQLPDO::exec($sql, $params);
        return $result;
    } 

    

    public static function equipoGanador() {
        $sql = "SELECT NombrEquipo, MAX(NVuelta) as NVuelta FROM equipos";
        $params =array();
        /*$result = MySQLPDO::select($sql, $params);
        return $result;*/


        /*$stmt = MySQLPDO::$base->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();*/
        
        
        $mysqli = new mysqli('localhost', 'root', 'root', 'velodromo');

	    if ($mysqli->connect_error) {
		    die('Error de Conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);}

	    $result = $mysqli->query($sql);
        $fila = $result->fetch_assoc();
        $arr=$fila["NombrEquipo"];

        return $arr;


    }
}
?>