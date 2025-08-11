<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    date_default_timezone_set('America/Caracas');
    header('Content-Type: text/html; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
    
    define("DS", DIRECTORY_SEPARATOR);
    define("EROOT", realpath(dirname(__FILE__)) . DS);
    define("APP_PATH", EROOT . "app" . DS);
    define("APP_ENTT", EROOT . "entities" . DS);
    
    try {
        require_once APP_PATH . 'Config.php';
        require_once APP_PATH . 'Requerido.php';
        require_once APP_PATH . 'Bootstrap.php';
        require_once APP_PATH . 'Controlador.php';
        require_once APP_PATH . 'PDOAdmin.php';
        require_once APP_PATH . 'Modl.php';
        require_once APP_PATH . 'Vista.php';
        //require_once APP_PATH . 'Session.php';
        require_once APP_PATH . 'Hash.php';
        
        //Session::init();
        Bootstrap::run(new Requerido());
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }//new880