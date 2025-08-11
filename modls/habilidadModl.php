<?php
class habilidadModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($nombre) {
        try {
            $sql = "INSERT INTO habilidades(hablid,  nombre)
                                     VALUES(:hablid,:nombre)";
            $hablid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":hablid", $hablid);
            $stmt->bindParam(":nombre",  $nombre);
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
    public function update($hablid, $nombre) {
        $sql = "UPDATE habilidades
                   SET nombre = :nombre
                 WHERE hablid = :hablid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":hablid", $hablid);
            $stmt->bindParam(":nombre",  $nombre);
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
            $sql = "SELECT hablid, nombre
                    FROM habilidades";
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
    public function getByName($nombre){
        try {
            $sql = "SELECT hablid, nombre
                    FROM habilidades
                    WHERE nombre = :nombre";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
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
    public function getById($hablid) {
        try {
            $sql = "SELECT hablid, nombre
                    FROM habilidades
                    WHERE hablid = :hablid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":hablid", $hablid);
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
    public function delete($hablid) {
        $sql = "DELETE FROM habilidades 
                WHERE hablid = :hablid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":hablid", $hablid);
            $stmt->execute();
            
            $stmt->MantenTbl("habilidades");
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