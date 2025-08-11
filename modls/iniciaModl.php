<?php

class iniciaModl extends Modl {

    function __construct() {
        parent::__construct();
    }
    
    public function obtUsrAll() {
        try {
            $key = Hash::getHash('md5', 'r1234', HASH_KEY);
            
            $sql = "SELECT count(*) as cuenta
            FROM usuarios";

            $rslt = $this->_db->prepare($sql);
            $rslt->execute();
            $cnta = $rslt->fetchObject()->cuenta;
            if ($cnta <= 0) {
                $sqli = "INSERT INTO usuarios(cliente,    usuario, clave, nivel, estatus, proyecto)
                                       VALUES('999999',  'Robgut', :key1,     0,       1, 0),
                                             ('999999','Robguter', :key1,     0,       1, 1)";
                $rslst = $this->_db->prepare($sqli);
                $rslst->bindParam(":key1",$key);
                $rslst->execute();
                $cnta++;
            }
            return $cnta;
        } catch (Exception $ex) {
            echo "obtUsrAll: " . $ex->getMessage();
        }
    }
    public function obtUsr($user,$pass) {
        try {
            $key = Hash::getHash('md5', $pass, HASH_KEY);
            $sql = "SELECT idusr, cliente, usuario, nivel, estatus, proyecto
            FROM usuarios
            WHERE usuario = ?
            AND clave = ?";

            $rslt = $this->_db->prepare($sql);
            $rslt->execute(
                array($user, $key)
            );
            return $rslt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function acceso($usr, $dirip) {
        try {
            $sql = "INSERT INTO acceso (usuario, dirip)
                    VALUES (?, ?)";

            $sntnc = $this->_db->prepare($sql);
            $rsl = $sntnc->execute(
                array($usr, $dirip)
            );
            return $rsl;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function BlockIp($dirip) {
        try {
            $sql = "INSERT INTO VARIOS (dirip)
                    VALUES (?)";

            $sntnc = $this->_db->prepare($sql);
            $rsl = $sntnc->execute(
                array($dirip)
            );
            return $rsl;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function BscIP($ip) {
        try {
            $sql = "SELECT dirip
                    FROM varios
                    WHERE dirip = ?";

            $datos = $this->_db->prepare($sql);
            $datos->execute(
                array($ip)
            );
            $rows = $datos->rowCount();
            if ($rows>0) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}