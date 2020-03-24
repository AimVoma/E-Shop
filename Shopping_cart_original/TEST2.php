<?php


session_start();


$_SESSION["skata1"]["1"] = "yoo" ;
$_SESSION["skata2"]["1"] = "yoo2" ;

foreach($_SESSION as $item)
   echo "skata" ;

