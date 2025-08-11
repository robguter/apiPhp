<?php
class indiceModl extends Modl {
    function __construct() {
        parent::__construct();
    }
    public function agregarCliente($nombre, $edad, $departamento)
    {
        $fechaRegistro = date("Y-m-d");
        $sql = "INSERT INTO clientes(nombre, edad, departamento, fecha_registro)
                     VALUES (?, ?, ? ,?)";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$nombre, $edad, $departamento, $fechaRegistro]);
        return $sentencia->fetchAll();
    }
    public function obtenerClientes()
    {
        $sql = "SELECT id, nombre, edad, departamento, fecha_registro FROM clientes";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
    public function buscarClientes($nombre)
    {
        $sql = "SELECT id, nombre, edad, departamento, fecha_registro FROM clientes WHERE nombre LIKE ?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute(["%$nombre%"]);
        return $sentencia->fetchAll();
    }
    public function eliminarCliente($id)
    {
        $sql = "DELETE FROM clientes WHERE id = ?";
        $sentencia = $this->_db->prepare($sql);
        return $sentencia->execute([$id]);
    }
    public function obtenerClientePorId($id)
    {
        $sql = "SELECT id, nombre, edad, departamento, fecha_registro FROM clientes WHERE id = ?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$id]);
        return $sentencia->fetchObject();
    }
    public function actualizarCliente($nombre, $edad, $departamento, $id)
    {
        $sql = "UPDATE clientes SET nombre = ?, edad = ?, departamento = ? WHERE id = ?";
        $sentencia = $this->_db->prepare($sql);
        return $sentencia->execute([$nombre, $edad, $departamento, $id]);
    }
    public function agregarVenta($idCliente, $monto, $fecha)
    {
        $sql = "INSERT INTO ventas(id_cliente, monto, fecha) VALUES (?, ?, ?)";
        $sentencia = $this->_db->prepare($sql);
        return $sentencia->execute([$idCliente, $monto, $fecha]);
    }
    public function obtNumTotCtes()
    {
        $sql = "SELECT COUNT(*) AS conteo FROM clientes WHERE id_cliente=?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$_SESSION['id']]);
        /**$sentencia = $this->_db->prepare("SELECT COUNT(*) AS conteo FROM clientes");
        $sentencia->execute();*/
        return $sentencia->fetchObject()->conteo;
    }
    public function obtNumTotCtesUlt30Dias()
    {
        $hace30Dias = date("Y-m-d", strtotime("-30 day"));
        $sql = "SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ? AND id_cliente=?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$hace30Dias,$_SESSION['id']]);
        /**$sentencia = $this->_db->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
        $sentencia->execute([$hace30Dias]);*/
        return $sentencia->fetchObject()->conteo;
    }

    public function obtNumTotCtesUltAnio()
    {
        $inicio = date("Y-01-01");
        $sql = "SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ? AND id_cliente=?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$inicio,$_SESSION['id']]);
        /**$sentencia = $this->_db->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
        $sentencia->execute([$inicio]);*/
        return $sentencia->fetchObject()->conteo;
    }

    public function obtNumTotCtesAniosAnt()
    {
        $inicio = date("Y-01-01");
        $sql = "SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro < ? AND id_cliente=?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$inicio,$_SESSION['id']]);
        return $sentencia->fetchObject()->conteo;
    }
    public function obtTotDeVentasS($id)
    {
        $sql = "SELECT saldo_dia as total
                FROM saldo_cliente
                WHERE cliente=? AND moneda='05'
                ORDER BY fecha_saldo DESC
                LIMIT 1";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute(array($id));
        $rs = $sentencia->fetch(PDO::FETCH_OBJ);
        $total = 0;
        if (!$rs)
            $total = 0;
        else
            $total = $rs->total;
        return $total;
    }
    public function obtTotDeVentasD($id)
    {
        $sql = "SELECT saldo_dia as total
                FROM saldo_cliente
                WHERE cliente=? AND moneda='06'
                ORDER BY fecha_saldo DESC
                LIMIT 1";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute(array($id));
        $rs = $sentencia->fetch(PDO::FETCH_OBJ);
        $total = 0;
        if (!$rs)
            $total = 0;
        else
            $total = $rs->total;
        return $total;
    }
    public function obtCtesPorDpto()
    {
        $sql = "SELECT departamento, COUNT(*) AS conteo
        FROM clientes
        WHERE id_cliente=?
        GROUP BY departamento";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$_SESSION['id']]);
        return $sentencia->fetchAll();
    }
    public function obtVtasAnioActOrgXMes()
    {
        $anio = date('Y');
        $sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS total
                FROM ventas
                WHERE YEAR(fecha) = ? AND id_cliente=?
                GROUP BY MONTH(fecha)";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$anio,$_SESSION['id']]);
        return $sentencia->fetchAll();
    }
    public function obtRepCtesEdes()
    {
        $rangos = [
            [1, 20],
            [21, 30],
            [31, 40],
            [41, 50],
            [51, 60],
            [61, 150],
        ];
        $resultados = [];
        foreach ($rangos as $rango) {
            $inicio = $rango[0];
            $fin = $rango[1];
            $conteo = $this->obtConteoCtesX_Edad($inicio, $fin);
            $dato = new stdClass;
            $dato->etiqueta = $inicio . " - " . $fin;
            $dato->valor = $conteo;
            array_push($resultados, $dato);
        }
        return $resultados;
    }
    public function obtConteoCtesX_Edad($inicio, $fin)
    {
        $sql = "select count(*) AS conteo from clientes
        WHERE edad >= ? AND edad <= ? AND id_cliente=?;";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$inicio, $fin,$_SESSION['id']]);
        return $sentencia->fetchObject()->conteo;
    }
    public function totalAcumuladoVentasPorCliente()
    {
        $sql = "SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$_SESSION['id']]);
        return $sentencia->fetchObject()->total;
    }

    public function totalAcumuladoVentasPorClienteEnUltimoMes()
    {
        $inicio = date("Y-m-01");
        $ql = "SELECT COALESCE(SUM(monto), 0) AS total
                FROM ventas WHERE id_cliente = ? AND fecha >= ?";
        $sentencia = $this->_db->prepare($ql);
        $sentencia->execute([$_SESSION['id'], $inicio]);
        return $sentencia->fetchObject()->total;
    }
    public function totalAcumuladoVentasPorClienteEnUltimoAnio()
    {
        $inicio = date("Y-01-01");
        $sql = "SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ? AND fecha >= ?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$_SESSION['id'], $inicio]);
        return $sentencia->fetchObject()->total;
    }
    public function totalAcumuladoVentasPorClienteAntesDeUltimoAnio()
    {
        $inicio = date("Y-01-01");
        $sql = "SELECT COALESCE(SUM(monto), 0) AS total
                FROM ventas WHERE id_cliente = ? AND fecha < ?";
        $sentencia = $this->_db->prepare($sql);
        $sentencia->execute([$_SESSION['id'], $inicio]);
        return $sentencia->fetchObject()->total;
    }

}