<?php
class Requerido {
    private $_control;
    private $_metodo;
    private $_argumentos;
    
    function __construct() {
        if ( isset( $_GET['url'] ) ) {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);
            
            $this->_control = strtolower( array_shift($url) );
            $this->_metodo = strtolower(array_shift($url) ?? '');
            $this->_argumentos = $url;
            
        }
        if ( !$this->_control ) {
            $this->_control = CNTR_PRD;
        }
        if ( !$this->_metodo ) {
            $this->_metodo = 'index';
        }
        if ( !isset($this->_argumentos) ) {
            $this->_argumentos = array();
        }
    }
    
    public function getControl() {
        return $this->_control;
    }
    public function getMetodo() {
        return $this->_metodo;
    }
    public function getArgs() {
        return $this->_argumentos;
    }
}