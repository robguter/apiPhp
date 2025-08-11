<?php
class habilidadControl extends Controlador {
    private $alma;
    private $_modl;
    private $_ajax;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('habilidad');
        
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
        $this->_vista->renderizar('habilidad');
    }
    public function Create() {
        if ($this->getSql('habilidad')) {
            $idct = null;
            $cate = $this->getSql('habilidad');
            $desc = $this->getSql('descripcion');
            $rslt = $this->_modl->Create($idct, $cate, $desc);
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
            $idca = $this->getSql('id');
            $cate = $this->getSql('habilidad');
            $desc = $this->getSql('descripcion');
            $rslt = $this->_modl->Update($idca, $cate, $desc);
            if ($rslt) {
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
            $rsp = "Error en la consulta";
            echo json_encode($rsp);
        }
    }
    public function getById() {
        if ($this->getSql('id')) {
            $idct = $this->getSql('id');
            $rslt = $this->_modl->getById($idct);
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
        if ($this->getSql('habilidad')) {
            $cate = $this->getSql('habilidad');
            $rslt = $this->_modl->getByName($cate);
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
            $idct = $this->getInt('id');
            $rslt = $this->_modl->Delete($idct);
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