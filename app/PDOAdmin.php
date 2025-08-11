<?php
class PDOAdmin extends PDO {
     private $_pdo;
     private $_pdoStt;
     private static $instance;
     private $drv = DRVCN;

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".DB_CHAR,
                             PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                             PDO::ATTR_EMULATE_PREPARES   => false);
     public function __construct() {
        $Cadena = $this->drv.":host=" . $this->host . ";dbname=" . $this->dbname;
        $Caden1 = $this->drv.":host=" . $this->host . ";";
        try {
            parent::__construct(
                $Cadena,
                $this->user,
                $this->pass,
                $this->options
            );
            
        }catch (PDOException $ex) {
            echo 'Error: ' . $ex->getMessage() . '<br>';
        }
     }
     /* Evita el copiado del objeto . Patr ón Singleton */
    private function __clone () { }
        
    /* Funci ón encargada de crear , si es necesario , el objeto. Funci ón a llamar desde fuera de 
    la clase para instanciar el objeto y utilizar sus mé todos */
    public static function getInstance () {
        if (!isset ( self::$instance ) ) {
            $object = __CLASS__ ;
            self::$instance = new $object ;
        }
        self::$instance->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
        return self::$instance;
    }
    private function createDatabase() {
      try {
        $this->_pdo = $this::getInstance();
        $sSql = "CREATE DATABASE IF NOT EXISTS {$this->dbname} CHARACTER SET ".DB_CHAR." COLLATE utf8mb4_0900_ai_ci;";
        $this->_pdoStt = $this->_pdo->prepare($sSql);
        $result = $this->_pdoStt->execute();
        echo "Base de datos creada exitosamente o ya existía.\n";
      } catch (PDOException $e) {
        die("Error al crear la base de datos: " . $e->getMessage());
      }
    }
    function CreaTabla($tabla = ''){
        $query = "CREATE TABLE IF NOT EXISTS :table(
            idcte INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50),
            telefono VARCHAR(20),
            apodo VARCHAR(20)
        )";
        $this->_pdoStt = $this->_pdo->prepare($query);
        $this->_pdoStt->bindParam(":table", $tabla);
        
        $result = $this->_pdoStt->execute();
        return $result;
    }
     function execute($query = '', $return_rows = 0, $array_valores = array(), $array_tipos= array()){
           $this->_pdoStt = $this->_pdo->prepare($query);
           foreach($array_valores as $posicion => &$valor){
                   $tipo_var = 'STR' == $array_tipos[$posicion] ? PDO::PARAM_STR : PDO::PARAM_INT;
                   $this->_pdoStt->bindParam($posicion+1, $valor, $tipo_var);
           }
           $result = $this->_pdoStt->execute();
           if( 0 < $return_rows && $result){
                 return $return_rows == 2 ? $this->_pdoStt->fetch() : $this->_pdoStt->fetchAll();
           }
           return $result;
     }
     function mostrar_error(){
         $array = $this->_pdoStt->errorInfo();
         var_dump($array);
     }
     function lastAddId(){
         return $this->_pdo->lastInsertId();
     }
}
?>