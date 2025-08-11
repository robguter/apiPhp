<?php
class calificacionModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($trabid, $calificadorid, $calificadoid, $puntuacion, $comentario, $fechacali) {
        try {
            $sql = "INSERT INTO calificaciones(trabid,  calificadorid, calificadoid, puntuacion, comentario, fechacali)
                                        VALUES(:trabid,:calificadorid,:calificadoid,:puntuacion,:comentario,:fechacali)";
            $caliid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":caliid", $caliid);
            $stmt->bindParam(":trabid",  $trabid);
            $stmt->bindParam(":calificadorid",  $calificadorid);
            $stmt->bindParam(":calificadoid", $calificadoid);
            $stmt->bindParam(":puntuacion",  $puntuacion);
            $stmt->bindParam(":comentario",  $comentario);
            $stmt->bindParam(":fechacali",  $fechacali);
            $stmt->execute();
            
            $iLastId = $this->_db->lastInsertId();
            $this->Retorna($stmt);
        }catch(PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function update($caliid, $trabid, $calificadorid, $calificadoid, $puntuacion, $comentario, $fechacali) {
        $sql = "UPDATE calificaciones
                   SET trabid = :trabid, calificadorid = :calificadorid, calificadoid = :calificadoid,
                       puntuacion = :puntuacion, comentario = :comentario, fechacali = :fechacali
                 WHERE caliid = :caliid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":caliid", $caliid);
            $stmt->bindParam(":trabid",  $trabid);
            $stmt->bindParam(":calificadorid",  $calificadorid);
            $stmt->bindParam(":calificadoid", $calificadoid);
            $stmt->bindParam(":puntuacion",  $puntuacion);
            $stmt->bindParam(":comentario",  $comentario);
            $stmt->bindParam(":fechacali",  $fechacali);
            $rslt = $stmt->execute();
            $this->Retorna($stmt);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function getAll() {
        try {
            $sql = "SELECT caliid, trabid, calificadorid, calificadoid, puntuacion, comentario, fechacali
                    FROM calificaciones";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                return "No se encontraron resultados.";
            } else {
                return $data;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function getByName($trabid){
        try {
            $sql = "SELECT caliid, trabid, calificadorid, calificadoid, puntuacion, comentario, fechacali
                    FROM calificaciones
                    WHERE trabid = :trabid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":trabid", $trabid);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                return "No se encontraron resultados.";
            } else {
                return $data;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function getById($caliid) {
        try {
            $sql = "SELECT caliid, trabid, calificadorid, calificadoid, puntuacion, comentario, fechacali
                    FROM calificaciones
                    WHERE caliid = :caliid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":caliid", $caliid);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                return "No se encontraron resultados.";
            } else {
                return $data;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage() . "<br>".
            "Código SQLSTATE: " . $e->getCode();
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage() . "<br>".
            "Código SQLSTATE: " . $ex->getCode();
        }
    }
    public function delete($caliid) {
        $sql = "DELETE FROM calificaciones 
                WHERE caliid = :caliid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":caliid", $caliid);
            $stmt->execute();
            
            $stmt->MantenTbl("calificaciones");
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