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
        <link rel="stylesheet" type="text/css" href="<?php echo $_Params['ruta_css']; ?>form.css" />
        <link rel="stylesheet" href="<?php echo $_Params['ruta_css']; ?>nav.css" />
        <script type='text/javascript' src="<?php echo $_Params['ruta_js']; ?>jquery-3.6.4.js"></script>
        <script type='text/javascript' src="<?php echo $_Params['ruta_js']; ?>Chart.min.js"></script>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            
            $item = array("Usuarios","Clientes","Ventas");
        ?>
    </head>
    <body>
        <div class="row ppal col-12">
            <div id="header" class="col-2 col-md-1">
                <img src="<?php echo $_Params['ruta_img']; ?>img/Srag.png"/>
            </div>
            <div id="title" class="col-10 col-sm-11 col-md-11">
                <h1>Sistema para el control de Procesos</h1>
            </div>
        </div>
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