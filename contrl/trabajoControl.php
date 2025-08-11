<?php
class trabajoControl extends Controlador {
    private $alma;
    private $_modl;
    private $_ajax;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('trabajo');
        
        $this->_vista->setJs(
            [
                'jquery.validate',
                'validator.min',
                'MiScript'
            ]
        );
        $this->_vista->setJsA(
            [
                'ajax'
            ]
        );
    }
    public function index() {
        
        $this->_vista->titulo = 'Portada';
        $this->_vista->renderizar('trabajo');
    }
    public function Create() {
        if ($this->getSql('nombre')) {
            $id = null;
            $idvt = $this->getSql('idvta');
            $fech = $this->getSql('fecha');
            $mnto = $this->getSql('monto');
            $mntd = $this->getSql('montod');
            $pagd = $this->getSql('pagada');

            $rslt = $this->_modl->Create($id, $idvt, $fech, $mnto, $mntd, $pagd);
            if ($rslt) {
                echo json_encode($rslt);
            }else{
                $rsp = [];
                $rsp["exito"]="0";
                $rsp["Resp"]="Error al Agregar el registro";
                echo json_encode($rsp);
            }
        }
    }
    public function Update() {
        if ($this->getSql('id')) {
            $id = $this->getSql('id');
            $idvt = $this->getSql('idvta');
            $fech = $this->getSql('fecha');
            $mnto = $this->getSql('monto');
            $mntd = $this->getSql('montod');
            $pagd = $this->getSql('pagada');
            $rslt = $this->_modl->Update($id, $idvt, $fech, $mnto, $mntd, $pagd);
            if ($rslt) {
                $rslt = $this->_modl->getAll();
                if ($rslt) {
                    /* $rsp = [];
                    $rsp["exito"]="1";
                    $rsp["Resp"]="Se ha Agregado el registro correctamente".$trabajo ." - ". $desc; */
                    echo json_encode($rslt);
                }else{
                    $rsp = [];
                    $rsp["data"]=null;
                    $rsp["exito"]="0";
                    $rsp["mensaje"]="Error";
                    echo json_encode($rsp);
                }
            }else{
                $rsp = [];
                $rsp["exito"]="0";
                $rsp["Resp"]="Error al Actualizar el registro";
                echo json_encode($rsp);
            }
        }
    }
    public function getAll() {
        $rslt = $this->_modl->getAll();
        if ($rslt) {
            echo json_encode($rslt);
        }else{
            $rsp = [];
            $rsp["data"]=null;
            $rsp["exito"]="0";
            $rsp["mensaje"]="Error";
            echo json_encode($rsp);
        }
    }
    public function getById() {
        if ($this->getSql('id')) {
            $id = $this->getSql('id');
            $rslt = $this->_modl->getById($id);
            if ($rslt) {
                echo json_encode($rslt);
            }else{
                $rsp = [];
                $rsp["data"]=null;
                $rsp["exito"]="0";
                $rsp["mensaje"]="Error";
                echo json_encode($rsp);
            }
        }
    }
    public function getByName() {
        if ($this->getSql('nombre')) {
            $trabajo = $this->getSql('nombre');
            $rslt = $this->_modl->getByName($trabajo);
            if ($rslt) {
                echo json_encode($rslt);
            }else{
                $rsp = [];
                $rsp["data"]=null;
                $rsp["exito"]="0";
                $rsp["mensaje"]="Error";
                echo json_encode($rsp);
            }
        }
    }
    public function Delete() {
        if ($this->getSql('id')) {
            $id = $this->getInt('id');
            $rslt = $this->_modl->Delete($id);
            if ($rslt) {
                echo json_encode($rslt);
            }else{
                $rsp = [];
                $rsp["data"]=null;
                $rsp["exito"]="0";
                $rsp["mensaje"]="Error";
                echo json_encode($rsp);
            }
        }
    }
}