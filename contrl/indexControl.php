<?php

class indexControl extends Controlador {private  $_login;
    private $_mdlo;
    function __construct() {
        parent::__construct();
        $this->_mdlo = $this->loadModl('inicia');
        $this->_vista->setJsA(array(
            'ajax'
            )
        );
        $this->_vista->setJs(array(
            'jquery-3.6.4.min',
            'jquery-3.6.4',
            'jquery.validate'
            )
        );
    }
    public function index() {
        
        //$dirip = DIR_IP;
        
        $this->_vista->titulo = "API de Ventas";
        $this->_vista->sbTitle = "Sistema control de Ventas";
        $this->_vista->renderizar('index');
    }
    public function accion() {
        //session_start();
        if ($_SESSION['code'] == strtolower($_POST['IdPr'])){
            echo "Bienvenidos a Sistema control de Clientes por favor 
                                      ingrese su usuario y contraseña para acceder";
        } else {
            echo "false";
        }
    }
    public function cerrar() {
        Session::destroy();
        $this->redireccionar();
    }
}