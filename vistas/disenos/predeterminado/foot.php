    
    <div class="container foot">&nbsp;</div>
    
    </body>
    <?php
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
    
    echo "
    <script>
        var strDir='" . BASE_URL . "';
        var strPub='" . PUBL_DIR . "';
    </script>";
    
    ?>
</html>