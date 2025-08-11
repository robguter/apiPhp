<?php
class pagoControl extends Controlador {
    private $alma;
    private $_modl;
    private $_ajax;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('pago');
        
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
        $this->_vista->renderizar('pago');
    }
    public function Create() {
        if ($this->getSql('nombre')) {
            $id = null;
            $nomb = $this->getSql('nombre');
            $tele = $this->getSql('telefono');
            $apod = $this->getSql('apodo');

            $rslt = $this->_modl->Create($id, $nomb,$tele, $apod);
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
            $nomb = $this->getSql('nombre');
            $tele = $this->getSql('telefono');
            $apod = $this->getSql('apodo');
            $rslt = $this->_modl->Update($id, $nomb,$tele, $apod);
            if ($rslt) {
                $rslt = $this->_modl->getAll();
                if ($rslt) {
                    /* $rsp = [];
                    $rsp["exito"]="1";
                    $rsp["Resp"]="Se ha Agregado el registro correctamente".$cte ." - ". $desc; */
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
            $cte = $this->getSql('nombre');
            $rslt = $this->_modl->getByName($cte);
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