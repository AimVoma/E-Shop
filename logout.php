<?php

session_start();
include_once("config.php");

if(isset($_GET["logout"]) ){
    unset($_SESSION["active_user"]);
    unset($_SESSION["e-shop"]);
    echo $JSC = <<<JSC
                    <script type="text/javascript">
                    window.location = "index.php" ;
                    exit();
                     </script>
JSC;
}