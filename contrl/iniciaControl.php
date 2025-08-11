<?php

class iniciaControl extends Controlador {

    private  $_modl;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('inicia');
        $this->_vista->setJs(array(
            'jquery-3.6.4',
            'jquery-ui.min',
            'bootstrap.min',
            'jquery.validate'
            )
        );
        $this->_vista->setJsA(array(
            'ajax'
            )
        );
        
    }
    public function index() {
        if (!Session::get('captcha')) {
            $this->redireccionar();
        }
        
        $this->_vista->titulo = "Iniciar Sesión";
        $this->_vista->sbTitle = "Por favor ingrese su usuario y contraseña para acceder";
        //$this->_vista->dats = $this->_modl->ObtProy();
        if ($this->getInt('enviar') == 2) {
            $this->_vista->datos = $_POST;
            
            if (!$this->obtAlfNm('Usuario')){
                $this->_vista->_error = "Debe introducir su nombre de Usuario";
                $this->_vista->renderizar('log_in','inicia');
                exit();
            }
            if (!$this->getSql('Clave')){
                $this->_vista->_error = "Debe introducir su Password";
                $this->_vista->renderizar('log_in','inicia');
                exit();
            }
            $fila = $this->_modl->obtUsr(
                $this->obtAlfNm('Usuario'),
                $this->getSql('Clave')
            );
            if (!$fila || count($fila)<=0) {
                $iInt = 0;
                if ( is_null(Session::get('intento'))) {
                    $iInt = 1;
                }else{
                    $iInt = Session::get('intento')+1;
                }
                if ($iInt>=3) {
                    Session::set('intento', 0);
                    $this->_vista->_error = "Usuario y/o password errado en " . strval(3-$iInt) . " intentos";
                    $this->redireccionar ();
                    exit();
                }else{
                    Session::set('intento', $iInt);
                    $this->_vista->_error = "Usuario y/o password errado. Le queda " . strval(3-$iInt) . " intentos";
                    $this->_vista->renderizar('log_in','inicia');
                    exit();
                }
            }
            $idusr = $fila['idusr'];
            Session::set('idcte', $fila['cliente']);
            Session::set('idusr', $idusr);
            Session::set('Usuario', $fila['usuario']);
            Session::set('Nivel', $fila['nivel']);
            Session::set('Estatus', $fila['estatus']);
            Session::set('RAIZ', BASE_URL);
            Session::set('autenticado', true);
            Session::set('tiempo', time());
            
            define('RAIZ', URL_BASE . "apifreelncr" . DS);
            
            $this->_vista->datos = $fila;
            $this->_vista->dats = $this->_modl->ObtProy();
            $num = count($this->_vista->dats);
            
            if ($num<=1) {
                $rs = $this->_vista->dats;

                $proy = $rs[0]["url"];
                Session::set('proyecto', $proy);
                define('URL_BASE0', URL_BASE . $proy . DS);
                define("ROOT", ROOTA . $proy . DS);
                
                
                $this->redireccion(URL_BASE0);
                exit();
            }

            $this->redireccion('selproy');
            exit();
        }else{
            $this->_vista->renderizar('log_in','inicia');
        }
    }
    
    public function registro() {
        sleep(1);
        /**if (Session::get('autenticado'))
            $this->redireccionar ();*/
        $this->_vista->titulo = 'Registro';
        if ($this->getInt('enviar') == 1) {
            try {
                $this->_vista->datos = $_POST;
                $nomb = $this->getSql('nombres');
                $apel = $this->getSql('apellidos');
                $usua = $this->obtAlfNm('usuario');
                $clav = $this->obtAlfNm('clave');
                $clvc = $this->obtAlfNm('confirm_clave');
                $prg1 = $this->getInt("pregseg1");
                $rsp1 = $this->getSql('respseg1');
                $prg2 = $this->getInt("pregseg2");
                $rsp2 = $this->getSql('respseg2');

                if ($clav != $clvc){
                    $this->_vista->_error = "Las Contraseñas no coinciden";
                    $this->_vista->alma = $this->_modl->ObtienePreg();
                    $this->_vista->renderizar('registro','inicia');
                    exit();
                }
                
                $bVerf = $this->_modl->vrfcaUsr($usua);
                if ( $bVerf ) {
                    $this->_vista->_error = "El Usuario "
                            . $this->obtAlfNm('usuario')
                            . " ya existe";
                    $this->_vista->alma = $this->_modl->ObtienePreg();
                    $this->_vista->renderizar('registro','inicia');
                    exit();
                }
                
                $iUltId = $this->_modl->registro(
                    $nomb,
                    $apel,
                    $usua,
                    $clav,
                    $prg1,
                    $rsp1,
                    $prg2,
                    $rsp2
                );
                $usuario = $this->_modl->vrfcaUsr( $usua );
                if (!$usuario) {
                    $this->_vista->_error = "Error al registrar usuario";
                    $this->_vista->alma = $this->_modl->ObtienePreg();
                    $this->_vista->renderizar('registro','inicia');
                    exit();
                }
                $resp = "Usuario registrado correctamente";
                $this->_vista->datos = false;
                $this->_vista->_mensaje = $resp;
                $this->_vista->renderizar('log_in','inicia');
                exit();
            } catch (Exception $e) {
                $this->_vista->_error = $e->getMessage();
                $this->_vista->alma = $this->_modl->ObtienePreg();
                $this->_vista->renderizar('registro','inicia');
                exit();
            }
        }
        $this->_vista->alma = $this->_modl->ObtienePreg();
        $this->_vista->renderizar('registro','inicia');
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