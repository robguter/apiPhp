<?php

class Bootstrap {
    
    public static function run(Requerido $peticion) {
        $controlador = $peticion->getControl() . 'Control';
        $rutaControl = EROOT . 'contrl' . DS . $controlador . '.php';
        //echo $rutaControl;
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();
        try {
            if (is_readable($rutaControl) ) {
                require_once $rutaControl;
                $controlador = new $controlador;
                if (is_callable(array($controlador, $metodo)) ) {
                    $metodo = $peticion->getMetodo();
                }else{
                    $metodo = 'index';
                }
                if (isset( $args ) && !empty( $peticion->getArgs() )) {
                    call_user_func_array(array($controlador,$metodo),$peticion->getArgs());
                }else{
                    call_user_func(array($controlador,$metodo));
                } 
            }else{
                throw new Exception() . " BTST " . $rutaControl;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}