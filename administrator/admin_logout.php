<?php
if(isset($_GET["logout"]))
{
    header('Location:http://localhost/e-shop/index.php');    
    die;
}