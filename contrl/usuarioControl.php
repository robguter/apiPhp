<?php
     header('Content-Type: application/json');

class usuarioControl extends Controlador {
    private $alma;
    private $_modl;
    private $_ajax;
    function __construct() {
        parent::__construct();
        $this->_modl = $this->loadModl('usuario');
        
        $this->_vista->setJs(
            array(
                'jquery.validate',
                'validator.min',
                'MiScript'
            )
        );
        $this->_vista->setJsA(
            array(
                'ajax'
            )
        );
    }
    public function index() {
        /* if ( Session::get('autenticado')=='' )
            header('location: ' . URL_BASE . 'apifreelncr/login'); */

        $this->_vista->titulo = 'Portada';
        $this->_vista->renderizar('usuario');
    }
    public function create() {
        header('Content-Type: application/json');
        $target_dir = PUBL_URL . 'img/';
        try {
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo crear el directorio de subida.']);
                    exit;
                }
            }
            if (isset($_FILES['imagen'])) {
                sleep(1);
                $file = $_FILES['imagen'];
                
                error_log("DEBUG: Contenido completo de \$_FILES['imagen']:");
                foreach ($file as $key => $value) {
                    error_log("DEBUG:   - $key: " . (is_array($value) ? json_encode($value) : $value));
                }
                error_log("DEBUG: Nombre original del archivo (desde Android): " . $file['name']);
                error_log("DEBUG: Nombre temporal del archivo en el servidor: " . $file['tmp_name']);
                error_log("DEBUG: Tipo MIME del archivo: " . $file['type']);
                error_log("DEBUG: Tamaño del archivo: " . $file['size'] . " bytes");
                error_log("DEBUG: Código de error de subida: " . $file['error']);
                // --- FIN LÍNEAS DE DEPURACIÓN ---

                if ($file['error'] === UPLOAD_ERR_OK) {
                    $fileName = $file['name'];
                    $fileTmp = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type']; // Ejemplo: "image/jpeg", "image/png"

                    // Intentar obtener la extensión del nombre original del archivo
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    // Mapeo de tipos MIME a extensiones comunes
                    $mimeToExt = [
                        'image/jpeg' => 'jpeg',
                        'image/png' => 'png',
                        'image/gif' => 'gif',
                        'image/webp' => 'webp', // Si alguna vez subes webp
                        // Agrega más si es necesario
                    ];
                    
                    if ($fileExt === 'tmp' || !in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (isset($mimeToExt[$fileType])) {
                            $fileExt = $mimeToExt[$fileType];
                            error_log("DEBUG: Extensión inferida del tipo MIME: ." . $fileExt);
                            exit;
                        } else {
                            // Si no podemos inferir la extensión del tipo MIME, usamos una por defecto o marcamos error.
                            // Para este caso, podemos intentar usar 'jpg' como fallback o simplemente reportar un error.
                            // Aquí optamos por reportar un error ya que no estamos seguros del tipo.
                            echo json_encode(['status' => 'error', 'message' => 'No se pudo determinar la extensión del archivo. Tipo MIME: ' . $fileType.  ' - '. $fileExt]);
                            exit;
                        }
                    }

                    // Define las extensiones de archivo permitidas (después de la inferencia)
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $newFile="";
                    // Verifica si la extensión (ya sea del nombre original o inferida) es permitida
                    if (in_array($fileExt, $allowedExtensions)) {
                        $this->_vista->datos = $_POST;
                        $nomb = $this->getSql('nombre');
                        $apel = $this->getSql('apellido');
                        $tele = $this->getSql('telefono');
                        $emai = $this->obtAlfNm('email');
                        $usua = $this->getSql('usuario');
                        $clav = $this->getSql('clave');
                        $tipo = $this->getSql('tipouser');
                        $info = $this->getSql("informacion");
                        $stts = $this->getSql('estatus');
                        
                        // Genera un nombre de archivo único para evitar colisiones
                        $newFile = uniqid('img_', true) . '.' . $fileExt;
                        $fileTrgt = $target_dir . $newFile;

                        // Mueve el archivo temporal a su destino final
                        if (move_uploaded_file($fileTmp, $fileTrgt)) {

                            $rslt = $this->_modl->create(
                                $nomb, $apel, $tele, $emai, $usua, $clav, $tipo, $info, $stts, $newFile
                            );
                            echo json_encode($rslt);
                            exit;
                            $userid = $rslt["userid"];
                            $imag = $rslt["imagen"];
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Imagen subida exitosamente.',
                                'userid' => isset($userid) ? $userid : 'N/A',
                                'nombre' => isset($nomb) ? $nomb : 'N/A',
                                'apellido' => isset($apel) ? $apel : 'N/A',
                                'telefono' => isset($tele) ? $tele : 'N/A',
                                'email' => isset($emai) ? $emai : 'N/A',
                                'usuario' => isset($usua) ? $usua : 'N/A',
                                'clave' => isset($clav) ? $clav : 'N/A',
                                'tipouser' => isset($tipo) ? $tipo : 'N/A',
                                'informacion' => isset($info) ? $info : 'N/A',
                                'estatus' => isset($stts) ? $stts : 'N/A',
                                'imagen' => $imag
                            ]);
                            exit;
                        } else { // Error al mover el archivo
                            echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo subido.']);
                            exit;
                        }
                    } else { // Extensión de archivo no permitida
                        echo json_encode(['status' => 'error', 'message' => 'Tipo de archivo no permitido. Solo se permiten JPG, JPEG, PNG, GIF. Name: '.$fileName ." - Tmp: " .$fileTmp ." - Archivo: ".$newFile." - Size: ".$fileSize]);
                            exit;
                    }
                } else { // Hubo un error en la subida del archivo (ej. tamaño excedido, archivo corrupto)
                    echo json_encode(['status' => 'error', 'message' => 'Error en la subida del archivo: ' . $file['error']]);
                    // Hubo un error en la subida del archivo (ej. tamaño excedido, archivo corrupto, etc.)
                    $errorMessage = 'Error en la subida del archivo. Código de error: ' . $file['error'];
                    switch ($file['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $errorMessage = 'El archivo subido excede el tamaño máximo permitido.';
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $errorMessage = 'El archivo se subió solo parcialmente.';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $errorMessage = 'No se subió ningún archivo.';
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $errorMessage = 'Falta una carpeta temporal en el servidor.';
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $errorMessage = 'Fallo al escribir el archivo en el disco.';
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $errorMessage = 'Una extensión de PHP detuvo la subida del archivo.';
                            break;
                    }
                    echo json_encode(['status' => 'error', 'message' => $errorMessage]);
                }
            } else { // Si el archivo 'imagen' no se encuentra en la petición
                echo json_encode(['status' => 'error', 'message' => 'Archivo de imagen "imagen" no recibido.']);
            }
        } catch (Exception $e) {
            $this->_vista->_error = $e->getMessage();
            exit();
        }
            
        $this->_vista->renderizar('create','usuario');
    }
    public function getAll() {
        try {
            $rslt = $this->_modl->getAll();
            echo json_encode($rslt);
        } catch (Exception $ex) {
            echo $ex->getMessage() . " - " . $ex->getLine() . " getAll";
        }
    }
    public function obtUser() {
        $idusr = Session::get("idusr");
        if ($this->getSql('clave')) {
            $pass = $this->getSql('clave');
            $rslt = $this->_modl->devUsrById($idusr,$pass);
            if ($rslt) {
                echo "Exito";
            }else{
                echo "Error";
            }
        }
    }
    public function delUser() {
        $sucu = Session::get('codsucursal');
        $iNvl = Session::get("Nivel");
        if ($this->getInt('idusr')) {
            $idusr = $this->getInt('idusr');
            $rslt = $this->_modl->delUser($idusr);
            if ($rslt) {
                $rsp = array();
                $rsp["exito"]="1";
                $rsp["Resp"]="Se ha eliminado el registro correctamente";
                echo json_encode($rsp);
            }else{
                $rsp = array();
                $rsp["exito"]="0";
                $rsp["Resp"]="Error al eliminar el registro";
                echo json_encode($rsp);
            }
            //$this->_vista->datos = $this->_modl->obtUsers($idcte, $iNvl);
            $this->_vista->datos = $this->_modl->obtUsers($sucu, $iNvl);
            $this->_vista->renderizar('edicion');
        }
    }
    public function edicion() {
        $this->_vista->titulo = 'Edición de Usuario';
        $idcte = Session::get("idcte");
        $iNvl = Session::get("Nivel");
        if ($this->getInt('enviar') == 1) {
            $this->_vista->datos = $_POST;
            $idusr = $this->getSql('idusr');
            $clnte = $this->getSql('cliente');
            $nomb = $this->getSql('nombres');
            $apel = $this->getSql('apellidos');
            $usua = $this->obtAlfNm('usuario');
            $nivl = $this->obtAlfNm('nivel');
            $idpto = $this->getSql('idpto');
            $iddta = $this->getSql('iddtoa');
            $dts = $this->_modl->actUsers(
                $idusr,$clnte,$nomb,$apel,$usua,$nivl,$idpto,$iddta
            );
            if ($dts <= 0) {
                $this->_vista->_error = "Error en el proceso de Actualizar OM";
                $this->_vista->datos = $this->_modl->obtUsers($idcte, $iNvl);
                $this->_vista->renderizar('edicion');
                exit();
            }
            $this->_vista->_mensaje = "El registro fué actualizado correctamente";
        }
        $this->_vista->datos = $this->_modl->obtUsers($idcte, $iNvl);
        $this->_vista->datos0 = $this->_modl->obtUsrDpts($idcte);
        $this->_vista->renderizar('edicion');
    }
    public function vrfCodigo() {
        sleep(1);
        try {
            $codi = $this->obtAlfNm("codigo");
            $rows = $this->_modl->vrfCodigo($codi);
            echo $rows;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function vrfUsuario() {
        sleep(1);
        try {
            $usua = $this->obtAlfNm("usuario");
            $rows = $this->_modl->vrfUsuario($usua);
            echo $rows;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function obtPregSegDos() {
        sleep(1);
        try {
            $prg1 = $this->getInt("pregseguno");
            $rows = $this->_modl->obtPregSegDs($prg1);
            
            echo json_encode($rows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function obtUsuario() {
        $idusr = $this->getSql('valor');
        $datos = $this->_modl->obtUsuario($idusr);
        echo json_encode($datos);
    }
    public function clave() {
        $this->_vista->titulo = 'Cambio de Clave';
        $idusr = Session::get("idusr");
        if ($this->getInt('enviar') == 1) {
            sleep(1);
            try {
                $this->_vista->datos = $_POST;
                $usua = $this->getSql('idusr');
                $clav = $this->getSql('clave');
                $clvc = $this->getSql('confirm_clave');
                if ($clav != $clvc){
                    $this->_vista->_error = "Las Contraseñas no coinciden";
                    $this->_vista->datos = $this->_modl->obtUsuario($idusr);
                    $this->_vista->renderizar('clave','usuario');
                    exit();
                }
                $rslt = $this->_modl->clave(
                    $idusr,$clav
                );
                $resp = "Ha cambiado su clave correctamente";
                $this->_vista->datos = $this->_modl->obtUsuario($idusr);
                $this->_vista->_mensaje = $resp;
                $this->_vista->renderizar('clave','usuario');
                exit();
            } catch (Exception $e) {
                $this->_vista->_error = $e->getMessage();
                $this->_vista->renderizar('clave','usuario');
                exit();
            }
        }
        $this->_vista->datos = $this->_modl->obtUsuario($idusr);
        $this->_vista->renderizar('clave','usuario');
    }
    public function valida() {
        $usr=$_REQUEST["usr"];
        $psw=$_REQUEST["psw"];
        $cnConn = new PDO("mysql:host=localhost;dbname=sisterag_DB","sisterag_Robgut","51573Rag$");
        $rsp = $cnConn->query("Select * from alumnos where codalu='$usr' and claalu='$psw'");
        $datos = array();
        foreach ($rsp as $fila) {
            $datos[]=$fila;
        }
        echo json_encode($datos);
        //$this->_vista->renderizar('valida','usuario');
    }
    public function ProcUsr() {
        sleep(1);
        if (Session::get('autenticado')) {
            $this->_vista->_error = "Usted ya está registrado";
            $this->redireccionar ();
        }
        $this->_vista->titulo = 'Registro';
        if ($this->obtPstPrm('Email')){
            $this->_vista->datos = $_POST;
            if (!$this->getSql('Nombre')){
                $this->_vista->_error = "Debe introducir su Nombre";
                $this->_vista->renderizar('usuario');
                exit();
            }
            if (!$this->obtAlfNm('Usuario')){
                $this->_vista->_error = "Debe introducir su nombre de Usuario";
                $this->_vista->renderizar('usuario');
                exit();
            }
            if (!$this->getSql('Clave')){
                $this->_vista->_error = "Debe introducir su Contraseña";
                $this->_vista->renderizar('usuario');
                exit();
            }
            $this->getLibs('class.phpmailer');
            $mail = new PHPMailer();
            $this->_modl->regUsr(
                $this->obtPstPrm('Email'),
                $this->getSql('Nombre'),
                $this->obtAlfNm('Usuario'),
                $this->obtAlfNm('Clave'),
                $this->getInt('Role')
            );
            $usuario = $this->_modl->vrfcaUsr(
                $this->obtAlfNm('Usuario')
            );
            if (!$usuario) {
                $this->_vista->_error = "Error al registrar usuario";
                $this->_vista->renderizar('usuario');
                exit();
            }
            $mail->From = 'robgutgom@gmail.com';
            $string = 'Robert Gutiérrez';
            //$mail->FromName = mb_convert_encoding('Robert Gutiérrez');
            $mail->FromName = mb_convert_encoding($string, 'UTF-8');
            
            $string = 'Activación de cuenta de usuario';
            //$mail->Subject = mb_convert_encoding('Activación de cuenta de usuario');
            $mail->Subject = mb_convert_encoding($string, 'UTF-8');
            $string = $usuario['Usuario'];
            $mail->Body = 'Hola <strong>' . mb_convert_encoding($string, 'UTF-8')
                    . '</strong>,'
                    . '<p>Se ha registrado en SISTERAG para activar '
                    . 'su cuenta haga clic sobre el enlace siguiente: <br>'
                    . '<a href=' . BASE_URL . 'php/activar/'
                    . $usuario['Id'] . '/' . $usuario['Usuario'] . '>'
                    . 'Activar Registro</a>';

            $mail->AltBody = 'Su servidor de correo no soporta html';
            $mail->addAddress($this->obtPstPrm('Email'));
            $mail->send();
            $this->_vista->_mensaje = "Registro ingresado satisfactoriamente";
            echo json_encode(
                $this->_modl->obtUsrs()
            );
        }
    }
    public function VrfcUsr() {
        echo json_encode(
            $this->_modl->vrfcaUsr(
                $this->obtAlfNm('Usuario')
            )
        );
    }
    public function VrfcEmail() {
        echo json_encode(
            $this->_modl->vrfcEmail(
                $this->obtPstPrm('Email')
            )
        );
    }
    private function obtRoleNum($param) {
        $var = "";
        switch ($param) {
            case 1:
                $var = 'admin';
                break;
            case 2:
                $var = 'especial';
                break;
            case 3:
                $var = 'usuario';
                break;
            default:
                $var = 'usuario';
                break;
        }
        return $var;
    }
    public function activar($id,$usuario) {
        sleep(1);
        if (!$this->FltrInt($id) || !$usuario) {
            $this->_vista->_error = "Estos datos no existen";
            $this->_vista->renderizar('activar');
            exit();
        }
        $fila = $this->_modl->obtUsr(
            $this->FltrInt($id),
            $usuario
        );
        if (!$fila) {
            $this->_vista->_error = "Esta cuenta no existe";
            $this->_vista->renderizar('activar');
            exit();
        }
        if ($fila['Estado'] == 1) {
            $this->_vista->_error = "Esta cuenta ya ha sido activada";
            $this->_vista->renderizar('activar');
            exit();
        }
        $fila = $this->_modl->actUsr(
            $this->FltrInt($id),
            $usuario
        );
        $fila = $this->_modl->obtUsr(
            $this->FltrInt($id),
            $usuario
        );
        if ($fila['Estado'] == 0) {
            $this->_vista->_error = "Error al activar la cuenta, por favor intente mas tarde";
            $this->_vista->renderizar('activar');
            exit();
        }
        //$this->_vista->_mensaje = "Su cuenta ha sido activada";
        $this->_vista->renderizar('activar');
    }
    public function consultar() {
        $this->_vista->titulo = 'Consulta de Usuarios';
        $idcte = Session::get("idcte");
        $sucu = Session::get('codsucursal');
        
        $this->_vista->datos = $this->_modl->obtTodos();
        $this->_vista->renderizar('consultar','panel');
    }
}