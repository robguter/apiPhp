<?php
class proyectoModl extends Modl {
    function __construct() {
        parent::__construct();
        //SELECT id, idcpra, fecha, monto, montod, pagada FROM ctasxpagar
    }
    public function create($cnteid, $titulo, $descripcion, $presupuesto, $fechacreacion, $fechalimite, $estado) {
        try {
            $sql = "INSERT INTO proyectos(cnteid,  titulo, descripcion, presupuesto, fechacreacion, fechalimite, estado)
                                   VALUES(:cnteid,:titulo,:descripcion,:presupuesto,:fechacreacion,:fechalimite,:estado)";
            $proyid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":proyid", $proyid);
            $stmt->bindParam(":cnteid",  $cnteid);
            $stmt->bindParam(":titulo",  $titulo);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":presupuesto",  $presupuesto);
            $stmt->bindParam(":fechacreacion",  $fechacreacion);
            $stmt->bindParam(":fechalimite",  $fechalimite);
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
    public function update($proyid, $cnteid, $titulo, $descripcion, $presupuesto, $fechacreacion, $fechalimite, $estado) {
        $sql = "UPDATE proyectos
                   SET cnteid = :cnteid, titulo = :titulo, descripcion = :descripcion, presupuesto = :presupuesto,
                       fechacreacion = :fechacreacion, fechalimite = :fechalimite, estado = :estado, 
                 WHERE proyid = :proyid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":proyid", $proyid);
            $stmt->bindParam(":cnteid",  $cnteid);
            $stmt->bindParam(":titulo",  $titulo);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":presupuesto",  $presupuesto);
            $stmt->bindParam(":fechacreacion",  $fechacreacion);
            $stmt->bindParam(":fechalimite",  $fechalimite);
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
            $sql = "SELECT proyid, cnteid, titulo, descripcion, presupuesto, fechacreacion, fechalimite, estado
                    FROM proyectos";
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
    public function getByName($cnteid){
        try {
            $sql = "SELECT proyid, cnteid, titulo, descripcion, presupuesto, fechacreacion, fechalimite, estado
                    FROM proyectos
                    WHERE cnteid = :cnteid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":cnteid", $cnteid);
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
    public function getById($proyid) {
        try {
            $sql = "SELECT proyid, cnteid, titulo, descripcion, presupuesto, fechacreacion, fechalimite, estado
                    FROM proyectos
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
    public function delete($proyid) {
        $sql = "DELETE FROM proyectos 
                WHERE proyid = :proyid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":proyid", $proyid);
            $stmt->execute();
            
            $stmt->MantenTbl("proyectos");
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