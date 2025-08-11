<!DOCTYPE HTML>
<html lang='es'>
    <head>
        <title><?php echo APP_NAME; ?></title>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <META content='Sisterag, Sistema, Basic, C#, .Net, Visual, Programación, Asesoría Técnica, Redes, Hosting, Alojamiento, Dominio, web' name='title'>
        <META http-equiv='title' content='Sisterag, Sistema, Basic, C#, .Net, Visual, Programación, Asesoría Técnica, Redes, Hosting, Alojamiento, Dominio, web'>
        <META content='Sisterag, Sistema, Basic, C#, .Net, Visual, Programación, Asesoría Técnica, Redes, Hosting, Alojamiento, Dominio, web' name='description'>
        <META content='Sisterag, Sistema, Basic, C#, .Net, Visual, Programación, Asesoría Técnica, Redes, Hosting, Alojamiento, Dominio, web' name='keywords'>
        <META content='Sisterag' name='copyright'>
        <META content='Ing. Robert Antonio Gutiérrez Gómez' name='AUTHOR'>
        <META name='Author' content='Ing. Robert Antonio Gutiérrez Gómez'>
        <META name='Registro' content='Productos, Programación'>
        <META name='description' content='Sistemas de escritorio, sitios webs, redes, mantenimiento y reparación de computadoras'>
        <META name='keywords' content='Sisterag, Sistema, Basic, C#, .Net, Visual, Programación, Asesoría Técnica, Redes, Hosting, Alojamiento, Dominio, web'>
        <META name='title' content='Sisterag.com.ve, Realizado por Robert Gutierrez de Inversiones Sisterag 2008, C. A.'>
        <link rel="icon" type="image/png" href="<?php echo $_Params['ruta_img']; ?>img/SragI.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>fontawesome/css/fontawesome.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>fontawesome/css/brands.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>fontawesome/css/solid.css" />
    
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>estiloA.css" />
        <link rel='stylesheet' href="<?php echo $_Params['ruta_css']; ?>nav.css" />
        <script type='text/javascript' src="<?php echo $_Params['ruta_js']; ?>jquery-3.6.4.min.js"></script>
        <?php
            if($this->_control == 'proceso') {
                echo "<script type='text/javascript' src='".$_Params['ruta_js']."jspdf.min.js'></script>";
                echo "<script type='text/javascript' src='".$_Params['ruta_js']."JsBarcode.all.min.js'></script>";
            }
        ?>
        <?php
            if($this->_control == 'index') {
                echo "<script type='text/javascript' src='".$_Params['ruta_js']."Chart.min.js'></script>";
            }
        ?>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $item = array("Usuarios","Clientes","Ventas");
        ?>
    </head>
    <body>

    <nav>
        <div class="logo"><a href="<?php echo BASE_URL; ?>">
            <img src="<?php echo $_Params['ruta_img']; ?>img/Srag.png"></a>
        </div>
        <ul class="menu">
                <?php
                $i=0;
            foreach ($_Params["menu"] as $menu) {
                $enlac = $menu['enlace'];
                $titul = $menu['titulo'];
                if ($menu['enlace'] != "") {
                    echo "<li class='item'>
                    <a href='$enlac'>$titul</a>
                    </li>";
                }else{
            echo "<li class='item has-submenu'>
                    <a tabindex='0'>$titul</a>
                    <ul class='submenu'>";
                    $smnue = "submenu".$i;
                    foreach ($_Params[$smnue] as $sbmenu) {
                        $enlacsb = $sbmenu['enlace'];
                        $titulsb = $sbmenu['titulo'];
                    echo "<li class='subitem'>
                    <a href='$enlacsb' >$titulsb</a>
                    </li>";
                    }
                echo "</ul></li>";
                }
                $i++;
            }
                ?>
                    <li class="toggle"><a><i class="fas fa-bars"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
        
    <div class="container gnrl">
        <div class='error'></div>
        <div class='mensaje'></div>
        <?php
        if (isset($this->_error)) {
            $Contn = $this->_error;
            ?>
            <script>
                $(".error").html("<b><?php echo $Contn;?></b>");
                setTimeout(function() {
                    $(".error").fadeIn(2000);
                },300);
                setTimeout(function() {
                    $(".error").fadeOut(2500);
                },3000);
                
            </script>
            <?php
        }
        if (isset($this->_mensaje)) {
            $Contn = $this->_mensaje;
            ?>
            <script>
                $(".mensaje").html("<b><?php echo $Contn;?></b>");
                setTimeout(function() {
                    $(".mensaje").fadeIn(2000);
                },300);
                setTimeout(function() {
                    $(".mensaje").fadeOut(2500);
                },3000);
            </script>
            <?php
        }
        ?>