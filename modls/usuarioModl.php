<?php
    header('Content-Type: application/json');
class usuarioModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($nombre,$apellido,$telefono,$email,$usuario,$clave,$tipouser,$informacion,$estatus,$imagen) {
        header('Content-Type: application/json');
        try {
            
            $sql = "INSERT INTO usuarios(nombre,  apellido, telefono, email, usuario, clave, tipouser, informacion, estatus, imagen)
                                  VALUES(:nombre,:apellido,:telefono,:email,:usuario,:clave,:tipouser,:informacion,:estatus,:imagen)";
            $esta = 1;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":nombre",$nombre);
            $stmt->bindParam(":apellido",$apellido);
            $stmt->bindParam(":telefono",$telefono);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":usuario",$usuario);
            $stmt->bindParam(":clave",$clave);
            $stmt->bindParam(":tipouser",$tipouser);
            $stmt->bindParam(":informacion",$informacion);
            $stmt->bindParam(":estatus",$estatus);
            $stmt->bindParam(":imagen",$imagen);
            $stmt->execute();
            $iLastId = $this->_db->lastInsertId();
            $rsp = $this->getById($iLastId);
            return $rsp;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . " <br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return $ex->getMessage() . "\n - " . $ex->getLine() . "\n createUser \n";
        }
            
    }
    public function getAll() {
        header('Content-Type: application/json');
        try {
            $sql = "SELECT a.userid, a.nombre, a.apellido, a.telefono, a.email, a.usuario, a.tipouser, a.informacion, a.estatus, a.imagen
                    FROM usuarios a
                    ";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function getById($userid) {
        try {
            $sql = "SELECT userid, nombre,  apellido, telefono, email, usuario, tipouser, informacion, estatus, imagen
                    FROM usuarios 
                    WHERE userid = :userid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function getByUC($usuario,$clave) {
        $clave = Hash::getHash('md5', $clave, HASH_KEY);

        $sql = "SELECT count(*) as cuenta
                FROM usuarios 
                WHERE userid = :userid AND usuario = :usuario AND clave = :clave";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":clave", $clave);
        $stmt->execute();
        $cont = $stmt->fetchObject()->cuenta;
        if ($cont > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function Delete($userid) {
        $sql = "DELETE FROM usuarios 
                WHERE userid=:userid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->execute();

            $stmt->MantenTbl("usuarios");
            $this->Retorna($stmt);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function Update($userid,$nombre,$apellido,$telefono,$email,$usuario,$clave,$tipouser,$informacion,$estatus,$imagen) {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, usuario = :usuario,
                clave = :clave, tipouser = :tipouser, informacion = :informacion, estatus = :estatus, imagen = :imagen
                WHERE userid = :userid";
                
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellido", $apellido);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":usuario", $usuario);
            $stmt->bindParam(":clave", $clave);
            $stmt->bindParam(":tipouser", $tipouser);
            $stmt->bindParam(":informacion", $informacion);
            $stmt->bindParam(":estatus", $estatus);
            $stmt->bindParam(":imagen", $imagen);
            $stmt->execute();
            
            $this->Retorna($stmt);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    private function Retorna($stmt) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($data)) {
            return "No se encontraron resultados.";
        } else {
            $data = $this->getAll();
        }
    }
}