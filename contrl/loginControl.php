<?php

class loginControl extends Controlador {

    private  $_login;
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
        
        $dirip = DIR_IP;
    
        if ($dirip != '::1') {
            $bval = $this->_mdlo->BscIP($dirip);
            if ($bval) {
                header("Location: https://www.google.com");
                exit();
            }
        }
        Session::set('captcha', false);
        $this->_vista->titulo = "Iniciar Sesión";
        $this->_vista->sbTitle = "Por favor ingrese la captcha";
        if ($this->getInt('enviar') == 1) {
            if ($_SESSION['code'] == strtolower($_POST['code'])){
                $this->_vista->sbTitle = "Bienvenidos a Sistema control de Clientes por favor 
                                            ingrese su usuario y contraseña para acceder";
                $this->_vista->_mensaje = "Captcha correcta";
                Session::set('captcha', true);
                $this->redireccionar ('inicia');
                exit();
                
            }else{
                if ( is_null(Session::get('intntc'))) {
                    $intn = 1;
                }else{
                    $intn = Session::get('intntc')+1;
                }
                Session::set('intntc', $intn);
                // $intn . " " . $dirip;
                $this->_vista->_error = "Captcha Errada";
                if ($intn>=10) {
                    //$this->_vista->datos = $this->_mdlo->BlockIp($dirip);
                    echo "
                        <script>
                            alert('ERROR GENERAL DEL SISTEMA, IP BLOQUEADA');
                        </script>
                    ";
                    header("Location: https://www.google.com");
                }else {
                    $this->_vista->renderizar('index','login');
                }
                exit();
            }
        } 
        $hora = date("H");
        $hr = intval($hora);
        if($hr < 6 || $hr > 21) {
            $this->_vista->_error="SISTEMA INACTIVO EN ESTE HORARIO";
        }else{
            $this->_vista->_error=null;
        }
        $this->_vista->renderizar('index','login');
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