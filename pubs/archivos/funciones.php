<?php

date_default_timezone_set("America/Caracas");
class globl {
    public function obtenerBD()
    {
        $password = "414345";
        $user = "Robguter";
        $dbName = "crm";
        $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
        $database->query("set names ".DB_CHAR);
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $database;
    }

    public function agregarCliente($nombre, $edad, $departamento)
    {
        $bd = $this->obtenerBD();
        $fechaRegistro = date("Y-m-d");
        $sentencia = $bd->prepare("INSERT INTO clientes(nombre, edad, departamento, fecha_registro) VALUES (?, ?, ? ,?)");
        return $sentencia->execute([$nombre, $edad, $departamento, $fechaRegistro]);
    }

    public function obtenerClientes()
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->query("SELECT id, nombre, edad, departamento, fecha_registro FROM clientes");
        return $sentencia->fetchAll();
    }

    public function buscarClientes($nombre)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro FROM clientes WHERE nombre LIKE ?");
        $sentencia->execute(["%$nombre%"]);
        return $sentencia->fetchAll();
    }


    public function eliminarCliente($id)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("DELETE FROM clientes WHERE id = ?");
        return $sentencia->execute([$id]);
    }

    public function obtenerClientePorId($id)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro FROM clientes WHERE id = ?");
        $sentencia->execute([$id]);
        return $sentencia->fetchObject();
    }
    public function actualizarCliente($nombre, $edad, $departamento, $id)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("UPDATE clientes SET nombre = ?, edad = ?, departamento = ? WHERE id = ?");
        return $sentencia->execute([$nombre, $edad, $departamento, $id]);
    }

    public function agregarVenta($idCliente, $monto, $fecha)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("INSERT INTO ventas(id_cliente, monto, fecha) VALUES (?, ?, ?)");
        return $sentencia->execute([$idCliente, $monto, $fecha]);
    }

    public function totalAcumuladoVentasPorCliente($idCliente)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ?");
        $sentencia->execute([$idCliente]);
        return $sentencia->fetchObject()->total;
    }

    public function totalAcumuladoVentasPorClienteEnUltimoMes($idCliente)
    {
        $inicio = date("Y-m-01");
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ? AND fecha >= ?");
        $sentencia->execute([$idCliente, $inicio]);
        return $sentencia->fetchObject()->total;
    }
    public function totalAcumuladoVentasPorClienteEnUltimoAnio($idCliente)
    {
        $inicio = date("Y-01-01");
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ? AND fecha >= ?");
        $sentencia->execute([$idCliente, $inicio]);
        return $sentencia->fetchObject()->total;
    }
    public function totalAcumuladoVentasPorClienteAntesDeUltimoAnio($idCliente)
    {
        $inicio = date("Y-01-01");
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas WHERE id_cliente = ? AND fecha < ?");
        $sentencia->execute([$idCliente, $inicio]);
        return $sentencia->fetchObject()->total;
    }

    public function obtNumTotCtes()
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->query("SELECT COUNT(*) AS conteo FROM clientes");
        return $sentencia->fetchObject()->conteo;
    }
    public function obtNumTotCtesUlt30Dias()
    {
        $hace30Dias = date("Y-m-d", strtotime("-30 day"));
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
        $sentencia->execute([$hace30Dias]);
        return $sentencia->fetchObject()->conteo;
    }

    public function obtNumTotCtesUltAnio()
    {
        $inicio = date("Y-01-01");
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
        $sentencia->execute([$inicio]);
        return $sentencia->fetchObject()->conteo;
    }

    public function obtNumTotCtesAniosAnt()
    {
        $inicio = date("Y-01-01");
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro < ?");
        $sentencia->execute([$inicio]);
        return $sentencia->fetchObject()->conteo;
    }

    public function obtTotDeVentas()
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->query("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas");
        return $sentencia->fetchObject()->total;
    }

    public function obtCtesPorDpto()
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->query("SELECT departamento, COUNT(*) AS conteo FROM clientes GROUP BY departamento");
        return $sentencia->fetchAll();
    }

    public function obtConteoCtesX_Edad($inicio, $fin)
    {
        $bd = $this->obtenerBD();
        $sentencia = $bd->prepare("select count(*) AS conteo from clientes WHERE edad >= ? AND edad <= ?;");
        $sentencia->execute([$inicio, $fin]);
        return $sentencia->fetchObject()->conteo;
    }

    public function obtVtasAnioActOrgXMes()
    {
        $bd = $this->obtenerBD();
        $anio = date("Y");
        $sentencia = $bd->prepare("select MONTH(fecha) AS mes, COUNT(*) AS total from ventas WHERE YEAR(fecha) = ? GROUP BY MONTH(fecha);");
        $sentencia->execute([$anio]);
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
}