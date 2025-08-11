<?php

class errorControl extends Controlador {

    function __construct() {
        parent::__construct();
        $this->_vista->setJs(array('jquery-3.6.4','jquery-ui.min','jquery.validate'),1);
        //$this->_vista->setJs(array('nuevo'),0);
    }
    public function index() {
        $this->_vista->titulo = 'Error';
        $this->_vista->_mensaje = $this->_getError();
        $this->_vista->renderizar('index');
    }
    public function access($codigo) {
        $this->_vista->titulo = 'Error';
        $this->_vista->_mensaje = $this->_getError($codigo);
        $this->_vista->renderizar('access');
    }
    private function _getError($codigo = false) {
        if ($codigo) {
            $codigo = $this->FltrInt($codigo);
            /* if (is_int($codigo))
                $codigo = $codigo; */
        } else {
            $codigo = 'default';
        }
        $error['default'] = "Ha ocurrido un error y la página no puede mostrarse";
        $error['5050'] = "Acceso Restringido";
        $error['8080'] = "Tiempo de la sesión agotado";
        if (array_key_exists($codigo,$error))
            return $error[$codigo];
        else
            return $error['default'];
    }
}