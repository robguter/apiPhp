<?php
class trabajoModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($proyid, $freeid, $descripcion, $presupuesto, $fechainicio, $fechafin, $estado) {
        try {
            $sql = "INSERT INTO trabajos(proyid,  freeid, descripcion, presupuesto, fechainicio, fechafin, estado)
                                   VALUES(:proyid,:freeid,:descripcion,:presupuesto,:fechainicio,:fechafin,:estado)";
            $trabid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":trabid", $trabid);
            $stmt->bindParam(":proyid",  $proyid);
            $stmt->bindParam(":freeid",  $freeid);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":presupuesto",  $presupuesto);
            $stmt->bindParam(":fechainicio",  $fechainicio);
            $stmt->bindParam(":fechafin",  $fechafin);
            $stmt->bindParam(":estado",  $estado);
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
    public function update($trabid, $proyid, $freeid, $descripcion, $presupuesto, $fechainicio, $fechafin, $estado) {
        $sql = "UPDATE trabajos
                   SET proyid = :proyid, freeid = :freeid, descripcion = :descripcion, presupuesto = :presupuesto,
                       fechainicio = :fechainicio, fechafin = :fechafin, estado = :estado, 
                 WHERE trabid = :trabid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":trabid", $trabid);
            $stmt->bindParam(":proyid",  $proyid);
            $stmt->bindParam(":freeid",  $freeid);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":presupuesto",  $presupuesto);
            $stmt->bindParam(":fechainicio",  $fechainicio);
            $stmt->bindParam(":fechafin",  $fechafin);
            $stmt->bindParam(":estado",  $estado);
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
            $sql = "SELECT trabid, proyid, freeid, descripcion, presupuesto, fechainicio, fechafin, estado
                    FROM trabajos";
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
    public function getByName($proyid){
        try {
            $sql = "SELECT trabid, proyid, freeid, descripcion, presupuesto, fechainicio, fechafin, estado
                    FROM trabajos
                    WHERE proyid = :proyid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":proyid", $proyid);
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
    public function getById($trabid) {
        try {
            $sql = "SELECT trabid, proyid, freeid, descripcion, presupuesto, fechainicio, fechafin, estado
                    FROM trabajos
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
    public function delete($trabid) {
        $sql = "DELETE FROM trabajos 
                WHERE trabid = :trabid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":trabid", $trabid);
            $stmt->execute();
            
            $stmt->MantenTbl("trabajos");
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