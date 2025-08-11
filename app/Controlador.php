<?php

abstract class Controlador {
    
    protected $_vista;
    public function __construct() {
        $this->_vista = new Vista(new Requerido());
    }
    abstract public function index();
    protected function loadModl($modelo) {
        $modelo = $modelo . 'Modl';
        $rutaModl = EROOT . 'modls' . DS . $modelo . '.php';
        if (is_readable($rutaModl) ) {
            require_once $rutaModl;
            $modelo = new $modelo;
            return $modelo;
        }else{
            throw new Exception('Error de modelo');
        }
    }
    protected function getArchs($clase) {
        $rutClass = EROOT . 'pubs' . DS . 'archivos' . DS . $clase . '.php';
        if (is_readable($rutClass) ) {
            require_once $rutClass;
            $clase = new $clase;
            return $clase;
        }else{
            throw new Exception('Error de libreria');
        }
    }
    protected function getLibs($libreria) {
        $rutaLibreria = EROOT . 'libs' . DS . $libreria . '.php';
        if (is_readable($rutaLibreria) ) {
            require_once $rutaLibreria;
        }else{
            throw new Exception('Error de libreria');
        }
    }
    protected function getTexto($valor) {
        if ( isset($_POST[$valor]) && !empty($_POST[$valor]) ) {
            $Texto = htmlspecialchars($_POST[$valor],ENT_QUOTES);
            return $Texto;
        }
        return '';
    }
    protected function getInt($valor) {
        if ( isset($_POST[$valor]) && !empty($_POST[$valor]) ) {
            $Entero = filter_input(INPUT_POST,$valor,FILTER_VALIDATE_INT);
            return $Entero;
        }
        return 0;
    }
    protected function getDbl($valor) {
        if ( isset($_POST[$valor]) && !empty($_POST[$valor]) ) {
            $Entero = filter_input(INPUT_POST,$valor,FILTER_VALIDATE_FLOAT);
            return $Entero;
        }
        return 0;
    }
    protected function redireccionar($ruta = false) {
        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit();
        } else {
            header('location:' . BASE_URL);
            exit();
        }
    }
    protected function redireccion($ruta) {
        header('location:' . $ruta);
        exit();
    }
    protected function FltrInt($valor) {
        $id = (int) $valor;
        if (is_int($id)) {
            return $id;
        }else{
            return 0;
        }
    }
    protected function obtPstPrm($valor) {
        if ( isset($_POST[$valor]) )
            return $_POST[$valor];
        return '';
    }
    protected function getSql($valor) {
        if ( isset($_POST[$valor]) && !empty($_POST[$valor]) ) {
            $_POST[$valor] = strip_tags($_POST[$valor]);
                $_valor = $_POST[$valor];
            return trim($_POST[$valor]);
        }
        return 0;
    }
    protected function obtAlfNm($valor) {
        if ( isset($_POST[$valor]) && !empty($_POST[$valor]) ) {
            $_POST[$valor] = (string) preg_replace('/[^A-Z0-9_-]/i', '', $_POST[$valor]);
            return trim($_POST[$valor]);
        }
    }
    public function vldEmail($email) {
        if (!filter_var($email,FILTER_VALIDATE_EMAIL))
            return false;
        return true;
    }
}