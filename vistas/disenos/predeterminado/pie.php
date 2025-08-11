    
    <div class="container foot">&nbsp;</div>
    <footer>
    <div class='InfoM'>Mas Información</div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="CpCntP">
                        <div>
                            <h4>Sitios de interés</h4>
                            <ul>
                                <li><a href="http://www.google.co.ve" target="Otro1">Google</a></li>
                                <li><a href="http://www.lawebdelprogramador.com" target="Otro2">La web del programador</a></li>
                                <li><a href="http://www.elguille.com" target="Otro3">El guille</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4>Destacados</h4>
                            <ul>
                                <li><a href="http://cnnespanol.cnn.com/cnnvenezuela/" target="Otro4">CNN Español</a></li>
                                <li><a href="https://www.caracoltv.com/" target="Otro5">Caracol Internacional</a></li>
                                <li><a href="http://www.rctvintl.com/esp/" target="Otro6">RCTV</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4>Contáctenos</h4>
                            <ul class="Ultima">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <div class="pie"> Copyright &COPY; <?php echo date("Y") . " " . APP_COMP; ?> </div>
                </div>
            </div>
        </div>
        
            <?php
            
            echo "
            <script>
                var strDir='" . BASE_URL . "';
                var strPub='" . PUBL_DIR . "';
            </script>";
            
            ?>
    </footer>
    </body>
    <?php
    array_push($_Params['jsg'], $_Params['ruta_js'] . "nav.js");
    if (isset($_Params["js"]) && count($_Params["js"])) {
        for ($i = 0; $i < count($_Params["js"]); $i++) {
            echo "<script type='text/javascript' src='" . $_Params['js'][$i] . "'></script>\n";
        }
    }
    if (isset($_Params["jsg"]) && count($_Params["jsg"])) {
        for ($i = 0; $i < count($_Params["jsg"]); $i++) {
            echo "<script type='text/javascript' src='" . $_Params['jsg'][$i] . "'></script>\n";
        }
    }
    ?>
</html>