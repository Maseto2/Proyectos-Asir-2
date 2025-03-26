<?php
class MySQLPDO {
    private static $host = "localhost" ;
    private static $database = "calificaciones";
    private static $username = "user_calif";
    private static $password = "pass_calif";
    private static $base;

    public static function connect(){
        if (MySQLPDO::$base != null) {
            MySQLPDO::$base = null;
        }
        try {
            $dsn = "mysql:host=" . MySQLPDO::$host . ";dbname=" . MySQLPDO::$database;
            MySQLPDO::$base = new PDO ($dsn,MySQLPDO::$username,MySQLPDO::$password);
            MySQLPDO::$base-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
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

    public static function insertarExamen($objetoExamen) {
        $sql = 'INSERT INTO examen (asignatura, enunciado1, puntuacion1, enunciado2, puntuacion2, aprobado) VALUES (?, ?, ?, ?, ?, ?) ';
        $params = array (
            $objetoExamen -> getAsignatura(),
            $objetoExamen -> getEnunciado1(),
            $objetoExamen -> getPuntuacion1(),
            $objetoExamen -> getEnunciado2(),
            $objetoExamen -> getPuntuacion2(),
            $objetoExamen -> getAprobado()
        );
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }

    public static function buscarAprobados($busqueda){
        $sql = "SELECT * FROM examen WHERE asignatura like ?";
        $params = array("%$busqueda%");
        $resultado = MySQLPDO::select($sql, $params);
        return $resultado;
    }


    public static function selectExamen($varId){
        $sql = "SELECT * FROM examen WHERE id = ?";
        $params = array ($varId);
        $resultado = MySQLPDO::select($sql, $params);
        if ($resultado != 0) {
            extract($resultado[0]);
            $objetoExamen = new Examen();
            $objetoExamen -> setId($id);
            $objetoExamen -> setAsignatura($asignatura);
            $objetoExamen -> setEnunciado1($enunciado1);
            $objetoExamen -> setPuntuacion1($puntuacion1);
            $objetoExamen -> setEnunciado2($enunciado2);
            $objetoExamen -> setPuntuacion2($puntuacion2);
            $objetoExamen -> setAprobado($aprobado);
            return $objetoExamen;
        } else {
            return null;
        }
    }

    public static function modificarExamen($objetoExamen) {
        $sql = 'UPDATE examen SET asignatura = ?, enunciado1 = ?, puntuacion1 = ?, enunciado2 = ?, puntuacion2 = ? WHERE id = ?';
        $params = array (
            $objetoExamen -> getAsignatura(),
            $objetoExamen -> getEnunciado1(),
            $objetoExamen -> getPuntuacion1(),
            $objetoExamen -> getEnunciado2(),
            $objetoExamen -> getPuntuacion2(),
            $objetoExamen -> getId()
        );
        $resultado = MySQLPDO::exec($sql, $params);
        return $resultado;
    }

    public static function borrarExamen($varId){
        $sql = "DELETE FROM examen WHERE id = ?";
        $params = array($varId);
        $resultado = MySQLPDO::exec($sql,$params);
        return $resultado;
    }
}

?>