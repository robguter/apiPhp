<?php
class Database {
    private static $instance = null;
    private $connection;

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".DB_CHAR);

    private function __construct() {
        try {
            $this->connection = new PDO(
              "mysql:host={$this->host};
              dbname={$this->dbname}",
              $this->user,
              $this->pass,
              $this->options);
            $this->connection->setAttribute(
              PDO::ATTR_ERRMODE,
              PDO::ERRMODE_EXCEPTION);
            $this->createDatabase("controlinv");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

     /* Evita el copiado del objeto . Patr ón Singleton */
    private function __clone () { }

    public static function getInstance() {
        if (self::$instance == null) {
            $object = __CLASS__ ;
            self::$instance = new $object ;
        }
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function createDatabase() {
      try {
        $this->connection->exec("CREATE DATABASE IF NOT EXISTS {$this->dbname} CHARACTER SET ".DB_CHAR." COLLATE utf8_unicode_ci;");
        echo "Base de datos creada exitosamente o ya existía.\n";
      } catch (PDOException $e) {
        die("Error al crear la base de datos: " . $e->getMessage());
      }
    }
}

// Ejemplo de uso
$db = Database::getInstance();
$conn = $db->getConnection();

// Ahora puedes usar $conn para ejecutar consultas
try {
    $stmt = $conn->prepare("SELECT * FROM tu_tabla");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($results);
} catch (PDOException $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}
?>