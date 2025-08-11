<?php

class Vista {
    
    private $_control;
    private $_js;
    private $_jsg;
    private $_svg;
    public $_argumn;
    public $alma;
    public $dtos;
    public $dtsdn;
    public $titulo;
    public $_error;
    public $datos;
    public $datos0;
    public $datos1;
    public $dats;
    public $_mensaje;
    public $totCtes;
    public $totCtesU30d;
    public $totCtesUano;
    public $totCtesAnsA;
    public $totVtas;
    public $CtesX_Dep;
    public $CtesX_Eda;
    public $VtasAnoAc;
    public $sbTitle;
    public $fecad;
    public $_varia;
    public $_Params;
    
    function __construct(Requerido $peticion) {
        $this->_control = $peticion->getControl();
        $this->_argumn = $peticion->getArgs();

        $this->_js = array();
        $this->_jsg = array();
        $this->_varia = array();
    }
    
    public function renderizar($vista, $item = false) {
        $menu = array(
            array(
                "id" => "procdia",
                "titulo" => "Procesos Diarios",
                "enlace" => ""
            ),
            array(
                "id" => "solicicte",
                "titulo" => "Solicitud Cliente",
                "enlace" => ""
            ),
            array(
                "id" => "prflusu",
                "titulo" => "Perfil del Usuario",
                "enlace" => ""
            ),
            array(
                'id' => 'login',
                'titulo' => 'Salir',
                'enlace' => BASE_URL . 'login/cerrar'
            )
        );
        $submenu0 = array(
            array(
                "id" => "movdia",
                "titulo" => "Consulta Movimiento Diario",
                "enlace" => BASE_URL . "movdia/movdia"
            ),
            array(
                "id" => "certifica",
                "titulo" => "Certificado",
                "enlace" => BASE_URL . "crtifi/crtifi"
            ),
            array(
                "id" => "disponible",
                "titulo" => "Disponibilidad Moneda",
                "enlace" => BASE_URL . "dispmone/dispmone"
            ),
            array(
                "id" => "faltasobra",
                "titulo" => "Sobrante y Faltante",
                "enlace" => BASE_URL . "sobrafalta/sobrafalta"
            )
        );
        $submenu1 = array(
            array(
                "id" => "comprobante",
                "titulo" => "Comprobante",
                "enlace" => BASE_URL . "comprobante"
            ),
            array(
                "id" => "comprobantevacio",
                "titulo" => "Comprobante de Contingencia",
                "enlace" => BASE_URL . "comprobantesd"
            ),
            array(
                "id" => "remesa",
                "titulo" => "Preparar Remesas Oficinas",
                "enlace" => BASE_URL . "remesa/remesa"
            ),
            array(
                "id" => "material",
                "titulo" => "Solicitud de Materiales",
                "enlace" => BASE_URL . "material/material"
            ),
            array(
                "id" => "estatus",
                "titulo" => "Estatus de Comprobantes",
                "enlace" => BASE_URL . "estatus/estatus"
            ),
            array(
                "id" => "solproxserv",
                "titulo" => "Solicitud Próximo Servicio",
                "enlace" => BASE_URL . "servicio/servicio"
            )
        );
        $submenu2 = array();
        //if (Session::get("Nivel") == 0) {
            $submenu2 = array(
                array(
                    "id" => "usua",
                    "titulo" => "Creación Usuario",
                    "enlace" => BASE_URL . "usuario/registro"
                ),
                array(
                    "id" => "usuar",
                    "titulo" => "Edición de Usuario",
                    "enlace" => BASE_URL . "usuario/usuario"
                ),
                array(
                    "id" => "usuaro",
                    "titulo" => "Oficina Moneda",
                    "enlace" => BASE_URL . "ofimon/ofimon"
                ),
                array(
                    "id" => "clav",
                    "titulo" => "Cambiar Clave",
                    "enlace" => BASE_URL . "usuario/clave"
                )
            );
        /* }else if (Session::get("Nivel") == 1) {
            $submenu2 = array(
               array("id" => "clav",
                "titulo" => "Cambiar Clave",
                "enlace" => BASE_URL . "usuario/clave"
                )
            );
        }else{
            $menu = array(
                array(
                    "id" => "solicicte",
                    "titulo" => "Solicitud Cliente",
                    "enlace" => ""
                ),
                array(
                    "id" => "prflusu",
                    "titulo" => "Perfil del Usuario",
                    "enlace" => ""
                ),
                array(
                    'id' => 'login',
                    'titulo' => 'Salir',
                    'enlace' => BASE_URL . 'login/cerrar'
                )
            );
            $submenu0 = array(
                array(
                    "id" => "comprobante",
                    "titulo" => "Comprobante",
                    "enlace" => BASE_URL . "comprobante"
                ),
                array(
                    "id" => "comprobantevacio",
                    "titulo" => "Comprobante de Contingencia",
                    "enlace" => BASE_URL . "comprobantesd"
                )
            );
            $submenu1 = array(
               array("id" => "clav",
                "titulo" => "Cambiar Clave",
                "enlace" => BASE_URL . "usuario/clave"
                )
            );
        } */
        $js = array();
        if (count($this->_js)){
            $js = $this->_js;
        }
        $jsg = array();
        if (count($this->_jsg)){
            $jsg = $this->_jsg;
        }       
        $_Params = array(
            'ruta_prd' => BASE_URL . 'vistas/disenos/predeterminado/',
            'ruta_pbl' => BASE_URL . 'pubs/',
            'ruta_css' => BASE_URL . 'pubs/css/',
            'ruta_img' => BASE_URL . 'pubs/img/',
            'ruta_js' => BASE_URL . 'pubs/js/',
            'menu' => $menu,
            'submenu0' => $submenu0,
            'submenu1' => $submenu1,
            'submenu2' => $submenu2,
            'item' => $item,
            "js" => $js,
            "jsg" => $jsg,
            "EROOT" => BASE_URL,
            "dirc" => BASE_URL . 'vistas' . DS . $this->_control,
            "configs" => array(
                'app_name' => APP_NAME,
                'APP_SLOG' => APP_SLOG,
                'APP_COMP' => APP_COMP
            )
        );
        $rutaVista = EROOT . 'vistas' . DS . $this->_control . DS . $vista . '.phtml';//.tpl'
        try {
            if (is_readable($rutaVista) ) {
                $chr = " ";
                $cntrl = trim($this->_control, $chr);
                $cadena = trim($cntrl, $chr);
                //echo $cadena;
                include_once EROOT . 'vistas' . DS . 'disenos' . DS . DSNO_PRD . DS . 'header.php';
                include_once $rutaVista;
                include_once EROOT . 'vistas' . DS . 'disenos' . DS . DSNO_PRD . DS . 'foot.php';
            }
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }
    public function setJs($jsU) {
        $Burl = BASE_URL . "pubs";
        if (is_array($jsU) && count($jsU) ) {
            for ($i=0; $i < count($jsU); $i++) {
                $this->_js[]  = $Burl . '/js/' . $jsU[$i] . '.js';
            }
        } else {
            throw new Exception('Error de JS');
        }
    }
    public function setJsA($jsU) {
        $Burl = BASE_URL . "vistas/" . $this->_control;
        if (is_array($jsU) && count($jsU) ) {
            for ($i=0; $i < count($jsU); $i++) {
                $this->_jsg[] = $Burl . '/js/' . $jsU[$i] . '.js';
            }
        } else {
            throw new Exception('Error de JS');
        }
    }
    Public function CargaImgns(){
        $Edir=PUBL_URL."Fondo";
        $dirint = dir($Edir);
        $n=0;
        $vinculo = array();
        while (($archivo = $dirint->read()) !== false) {
            if (preg_match("/jpg/", $archivo) || preg_match("/JPG/", $archivo)){
                $Matrz = explode( '.', $archivo );
                list($Nombre, $Extn) = $Matrz;
                $vinculo[$n]=$Edir . "/" . $archivo;
                $n++;
            }
        }
        $dirint->close();
        return $vinculo;
    }
}