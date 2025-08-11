<?php
class habiluserModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($freeid, $hablid, $nivel) {
        try {
            $sql = "INSERT INTO habilusers(hablid,  nivel)
                                    VALUES(:hablid,:nivel)";
            $caliid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":caliid", $caliid);
            $stmt->bindParam(":freeid",  $freeid);
            $stmt->bindParam(":hablid",  $hablid);
            $stmt->bindParam(":nivel", $nivel);
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
    public function update($freeid, $hablid, $nivel) {
        $sql = "UPDATE habilusers
                   SET hablid = :hablid, nivel = :nivel
                 WHERE freeid = :freeid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":freeid",  $freeid);
            $stmt->bindParam(":hablid",  $hablid);
            $stmt->bindParam(":nivel", $nivel);
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
            $sql = "SELECT freeid, hablid, nivel
                    FROM habilusers";
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
    public function getByName($freeid){
        try {
            $sql = "SELECT freeid, hablid, nivel
                    FROM habilusers
                    WHERE freeid = :freeid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":freeid", $freeid);
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
    public function getById($freeid) {
        try {
            $sql = "SELECT freeid, hablid, nivel
                    FROM habilusers
                    WHERE freeid = :freeid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":freeid", $freeid);
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
    public function delete($freeid) {
        $sql = "DELETE FROM habilusers 
                WHERE freeid = :freeid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":freeid", $freeid);
            $stmt->execute();
            
            $stmt->MantenTbl("habilusers");
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