<?php
// Convertir los resultados a formato JSON
//header('Content-Type: application/json');
class calificacionControl extends Controlador {
    private $alma;
    private $_modl;
    private $_ajax;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('calificacion');
        
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
        $this->_vista->titulo = 'CALIFICACION';
        $this->_vista->renderizar('calificacion');
    }
    
    public function Create() {
        header('Content-Type: application/json');
        $target_dir = PUBL_URL . 'img/';
        try {
            if (!isset($_POST['trabid'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            if (!isset($_POST['calificadorid'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            if (!isset($_POST['calificadoid'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            if (!isset($_POST['puntuacion'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            if (!isset($_POST['comentario'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            if (!isset($_POST['fechacali'])) {
                echo json_encode(['status' => 'error', 'message' => 'Campo de texto "campo_texto" no recibido.']); // No salimos aquí para permitir que el script intente procesar la comentario de todas formas
                exit;
            }
            $trabid  = $this->getInt('trabid');
            $calificadorid  = $this->getInt('calificadorid');
            $calificadoid  = $this->getInt('calificadoid');
            $puntuacion  = $this->getInt('puntuacion');
            $comentario  = $this->getSql('comentario');
            $fechacali  = $this->getSql('fechacali');
            $rslt = $this->_modl->Create($trabid, $calificadorid, $calificadoid, $puntuacion, $comentario, $fechacali);
            echo json_encode($rslt);
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " Create";
        }
    }
    public function Update(): void {
        try {
            if ($this->getInt('caliid')) {
                $caliid = $this->getInt('caliid');
                $trabid  = $this->getInt('trabid');
                $calificadorid  = $this->getInt('calificadorid');
                $calificadoid  = $this->getInt('calificadoid');
                $puntuacion  = $this->getInt('puntuacion');
                $comentario  = $this->getSql('comentario');
                $fechacali  = $this->getSql('fechacali');
                $rslt = $this->_modl->Update($caliid, trabid, $calificadorid, $calificadoid, $puntuacion, $comentario, $fechacali);
                echo json_encode($rslt);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " getAll";
        }
    }
    public function getAll() {
        try {
            $rslt = $this->_modl->getAll();
            echo json_encode($rslt);
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " getAll";
        }
    }
    public function getById() {
        try {
            if ($this->getInt('caliid')) {
                $caliid = $this->getInt('caliid');
                $rslt = $this->_modl->getById($caliid);
                echo json_encode($rslt);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " getById";
        }
    }
    public function getByName() {
        try {
            if ($this->getSql('calificadorid')) {
                $arti = $this->getSql('calificadorid');
                $rslt = $this->_modl->getByName($arti);
                echo json_encode($rslt);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " getByName";
        }
    }
    public function Delete() {
        try {
            if ($this->getInt('caliid')) {
                $caliid = $this->getInt('caliid');
                $rslt = $this->_modl->Delete($caliid);
                echo json_encode($rslt);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " Delete";
        }
    }
}