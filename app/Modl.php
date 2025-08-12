<?php

class Modl {
    protected $_db;
    protected $dba;
    private $drv = DRVCN;
    private $numrows;
    private $manejador;

    function __construct() {
        try {
            $this->_db = PDOAdmin::getInstance();
            $this->_db->exec("set charset ".DB_CHAR);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        $this->cargaTbls();
    }
    private function cargaTbls() {
        
        $cali = "CREATE TABLE IF NOT EXISTS calificaciones(
            caliid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            trabid INT NOT NULL,
            calificadorid INT NOT NULL,
            calificadoid INT NOT NULL,
            puntuacion INT NOT NULL,
            comentario VARCHAR(255),
            fechacali DATE NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($cali);
        $result = $_pdoStat->execute();
        
        $habl = "CREATE TABLE IF NOT EXISTS habilidades(
            hablid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(80) NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($habl);
        $result = $_pdoStat->execute();

        $hablusr = "CREATE TABLE IF NOT EXISTS habilusers(
            freeid INT NOT NULL PRIMARY KEY,
            hablid INT NOT NULL,
            nivel ENUM('Principiante', 'Intermedio', 'Experto') NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($hablusr);
        $result = $_pdoStat->execute();

        $pago = "CREATE TABLE IF NOT EXISTS pagos(
            pagoid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            trabid INT NOT NULL,
            monto DECIMAL(12,2) NOT NULL,
            fechapago DATE NOT NULL,
            metodopago VARCHAR(80) NOT NULL,
            estado ENUM('Pendiente', 'Procesando', 'Completado', 'Fallido') NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($pago);
        $result = $_pdoStat->execute();

        $preg = "CREATE TABLE IF NOT EXISTS pregseg(
            idpreg INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            pregunta VARCHAR(40) NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($preg);
        $result = $_pdoStat->execute();

        $proy = "CREATE TABLE IF NOT EXISTS proyectos(
            proyid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            cnteid INT NOT NULL,
            titulo VARCHAR(60) NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            presupuesto DECIMAL(12,2) NOT NULL,
            fechacreacion DATE,
            fechalimite DATE,
            estado ENUM('Abierto', 'En progreso', 'Completado', 'Cancelado') NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($proy);
        $result = $_pdoStat->execute();

        $resp = "CREATE TABLE IF NOT EXISTS respseg(
            idresp INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            idpreg INT NOT NULL,
            respuesta VARCHAR(20) NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($resp);
        $result = $_pdoStat->execute();

        $trab = "CREATE TABLE IF NOT EXISTS trabajos(
            trabid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            proyid INT NOT NULL,
            freeid INT NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            presupuesto DECIMAL(12,2) NOT NULL,
            fechainicio DATE,
            fechafin DATE,
            estado ENUM('Propuesto', 'Aceptado', 'En progreso', 'En revisión', 'Completado', 'Rechazado', 'Cancelado') NOT NULL
        )";
        $_pdoStat = $this->_db->prepare($trab);
        $result = $_pdoStat->execute();

        $user = "CREATE TABLE IF NOT EXISTS usuarios(
            userid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(30) NOT NULL,
            apellido VARCHAR(30) NOT NULL,
            telefono VARCHAR(15) NOT NULL,
            email VARCHAR(255) NOT NULL,
            usuario VARCHAR(15) NOT NULL,
            clave VARCHAR(255) NOT NULL,
            tipouser ENUM('Freelancer', 'Cliente') NOT NULL,
            informacion VARCHAR(255), /**habilidades para freelancers, empresa para clientes**/
            estatus ENUM('Activo', 'Inactivo', 'Suspendido') NOT NULL,
            imagen VARCHAR(255)
        )";
        $_pdoStat = $this->_db->prepare($user);
        $result = $_pdoStat->execute();
        
    }
    public function loadEntd($entd) {
        $rutaEntd = EROOT . 'entities' . DS . $entd . '.php';
        if (is_readable($rutaEntd) ) {
            require_once $rutaEntd;
            $entd = new $entd;
            return $entd;
        }else{
            throw new Exception('Error de Entidad '.$entd);
        }
    }
    public function Insertar($tabla, $cpos, $vlrs, $data) {
        try 
        {
        $sql = "INSERT INTO $tabla (". implode(",",$cpos) .") 
        VALUES ($vlrs)";

        $rslt = $this->_db->prepare($sql)
            ->execute(
                array(
                    $data->__GET( $cpos[0] ), 
                    $data->__GET( $cpos[1] ), 
                    $data->__GET( $cpos[2] ),
                    $data->__GET( $cpos[3] ),
                    $data->__GET( $cpos[4] ),
                    $data->__GET( $cpos[5] ),
                    $data->__GET( $cpos[6] )
                    )
            );
            if ($rslt) {
                $Ultimo = $this->_db->lastInsertId();
            } else {
                $Ultimo = NULL;
            }
            return $Ultimo;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
    //*******************************************************************
    /**
    * @todo Permite obtener datos mediante un arreglo asociativo o de objetos, concatenando las columnas y las tablas.
    * @access public
    * @param string $cols, string $tbl, bool $getObjs
    * @return mixed
    **/
    public final function queryg($cols, $tbl, $getObjs=false) {
        $rt = null;
        try {
            $query = $this->_db->prepare( " SELECT " . $cols . " FROM " . $tbl );
            $query->execute();
            $this->setNumRows( $query->rowCount() );
            //$this->_db->disconnect();
            if( $getObjs )
                $rt = $query->fetchAll(PDO::FETCH_ASSOC);
            else
                $rt = $query->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log( $e->getMessage() );
        }
        return $rt;
    }
    /**
    * @todo Borra la información de la conexión
    * @access public
    **/
    public final function disconnect() {
        $this->setConexion(null);
    }

    /**
    * @todo Devuelve la información de la conexión.
    * @access public
    * @return int
    **/
    public final function getConexion() {
        return $this->_db;
    }

    /**
    * @todo Guarda la información de la conexión a la base de datos.
    * @access private
    * @param mixed $conn
    **/
    private function setConexion($conn) {
        $this->_db = $conn;
    }

    /**
    * @todo Devuelve el alias del manejador de la base de datos.
    * @access public
    * @return string
    **/
    public final function getManejador() {
        return DRVCN; 
    }

    /**
    * @todo Guarda la información del alias del manejador de la base de datos.
    * @access private
    * @param string $manejador
    **/
    private function setManejador($manejador) {
        $this->manejador = $manejador;
    }

    /**
    * @todo Guarda la cantidad de filas afectadas en una consulta.
    * @access public
    * @param int $rows
    **/
    private function setNumRows( $rows ) {
        $this->numrows = $rows;
    }

    /**
    * @todo Devuelve la cantidad de filas afectadas en una consulta.
    * @access public
    * @return int $this->numrows
    **/
    public final function getNumRows() {
        return $this->numrows;
    }
    /**
    * @todo Devuelve las constantes definidas por la extensión PDO
    * @access private
    * @param mixed $var
    * @return mixed PDO::PARAM_
    **/
    private function getPDOConstantType($var) {
        if( is_int( $var ) )
        return PDO::PARAM_INT;
        if( is_bool( $var ) )
        return PDO::PARAM_BOOL;
        if( is_null( $var ) )
        return PDO::PARAM_NULL;
        return PDO::PARAM_STR;
    }
    
    public function MantenTbl($e) {
        /* $sql = "TRUNCATE TABLE " . $e;
        $stat = $this->_db->prepare($sql);
        $stat->execute(); */

        $sql = "ANALYZE TABLE " . $e;
        $stat1 = $this->_db->prepare($sql);
        $stat1->execute();
        
        /* $sql = "CHECK TABLE " . $e;
        $stat2 = $this->_db->prepare($sql);
        $stat2->execute(); */
        
        /** Desfragmentar **/
        $sql = "ALTER TABLE " . $e . " ENGINE = InnoDB";
        $stat3 = $this->_db->prepare($sql);
        $stat3->execute();
        
        /* $sql = "FLUSH TABLE " . $e;
        $stat4 = $this->_db->prepare($sql);
        $stat4->execute(); */
        
        $sql = "OPTIMIZE TABLE " . $e;
        $stat5 = $this->_db->prepare($sql);
        $stat5->execute();
        
        $sql = "ALTER TABLE " . $e . " AUTO_INCREMENT = 0";
        $stat4 = $this->_db->prepare($sql);
        $stat4->execute();
    }
    
}