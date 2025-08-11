<?php
class pagoModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function create($trabid, $monto, $fechapago, $metodopago, $estado) {
        try {
            $sql = "INSERT INTO pagos(pagoid,  trabid, monto, fechapago, metodopago, estado)
                                        VALUES(:pagoid,:trabid,:monto,:fechapago,:metodopago,:estado)";
            $pagoid = null;
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":pagoid", $pagoid);
            $stmt->bindParam(":trabid",  $trabid);
            $stmt->bindParam(":monto",  $monto);
            $stmt->bindParam(":fechapago", $fechapago);
            $stmt->bindParam(":metodopago",  $metodopago);
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
    public function update($pagoid, $trabid, $monto, $fechapago, $metodopago, $estado) {
        $sql = "UPDATE pagos
                   SET trabid = :trabid, monto = :monto, fechapago = :fechapago,
                       metodopago = :metodopago, estado = :estado
                 WHERE pagoid = :pagoid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":pagoid", $pagoid);
            $stmt->bindParam(":trabid",  $trabid);
            $stmt->bindParam(":monto",  $monto);
            $stmt->bindParam(":fechapago", $fechapago);
            $stmt->bindParam(":metodopago",  $metodopago);
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
            $sql = "SELECT pagoid, trabid, monto, fechapago, metodopago, estado
                    FROM pagos";
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
            $sql = "SELECT pagoid, trabid, monto, fechapago, metodopago, estado
                    FROM pagos
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
    public function getById($pagoid) {
        try {
            $sql = "SELECT pagoid, trabid, monto, fechapago, metodopago, estado
                    FROM pagos
                    WHERE pagoid = :pagoid";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":pagoid", $pagoid);
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
    public function delete($pagoid) {
        $sql = "DELETE FROM pagos 
                WHERE pagoid = :pagoid";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(":pagoid", $pagoid);
            $stmt->execute();
            
            $stmt->MantenTbl("pagos");
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