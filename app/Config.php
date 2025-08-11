<?php
    $_Dir=$_SERVER['DOCUMENT_ROOT'];
    $_DirS=$_SERVER['SCRIPT_FILENAME'];
    $s = $_SERVER;
    $ssl = ( ! empty($s['HTTPS']) && $s['HTTPS'] == 'on' ) ? true:false;
    $sp = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/'  )) . ( ( $ssl ) ? 's' : '' );
    $port = $s['SERVER_PORT'];
    $port = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port=='443' ) ) ? '' : ':' . $port;
    $host = ( false && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    $protocol .= '://' . $host . $_SERVER['REQUEST_URI'];
    $dirip = getRealIP();
    $drv = 'mysql';
    //$drv = 'pgsql';
    $url = explode('/', $_DirS);
    $url1 = strtolower( array_pop($url) );
    $DirS = implode("/",$url);
    $_strDir =trim($DirS."/");
    define('ROOTC', $_strDir."pubs/img/");
    define('DRVCN', $drv);
    $url1 = strtolower( array_pop($url) );
    $sDir = trim(implode("/",$url));
    $sDir = trim($sDir."/");
    define('ROOTA', $sDir);
    $mPartes = explode("/", $protocol);
    $prtcl = $mPartes[0] . "//" . $mPartes[2] . "/";
        $protocol = $mPartes[0] . "//" . $mPartes[2] . "/" . $mPartes[3] . "/";
        define("DB_USER", "Robguter");
        define("DB_PASS", "150269");
        define("DB_NAME", "appfreecte");
    define('SPTXT', ';');
    define('URL_BASE', $prtcl);
    define('BASE_URL', $protocol);
    /* define('BASEURLC', URL_BASE . "cliente/");
    define('BASEURLS', URL_BASE . "solicitud/"); */
    define('PUBL_URL', 'pubs/');
    define('PUBL_DIR', BASE_URL.'pubs/img/');
    define('CNTR_PRD', 'index');
    define('DSNO_PRD', 'predeterminado');
    define('APP_NAME', 'Sistema Control de Clientes');
    define('APP_SLOG', 'Mi framework personal con PHP y MVC');
    define('APP_COMP', 'Inversiones Sisterag 2008, C. A.');
    define('CSN_TIME', 1000);
    define('HASH_KEY', 'R083r76u7');
    define('DB_HOST', 'localhost');
    define('DB_CHAR', 'utf8mb4');
    
    define('REG_CREADO', 101);
    define('REG_EXISTE', 102);
    define('REG_FAILURE', 103);

    define('DIR_IP', $dirip);
    define('PSSEML', "Fau571n05An");
    
    function getRealIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }