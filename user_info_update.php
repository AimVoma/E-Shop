<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$query = sprintf
("
    UPDATE user
    SET name = '%s' , sname = '%s', phone = '%s', adress = '%s',postal_code = '%s',email ='%s', proficiency = '%s'
    WHERE usr_id = '%s';    
",
    $mysqli->escape_string($_GET["usr_name"]),
    $mysqli->escape_string($_GET["usr_sname"]),    
    $mysqli->escape_string($_GET["usr_phone"]),    
    $mysqli->escape_string($_GET["usr_adress"]),    
    $mysqli->escape_string($_GET["usr_postal_code"]),    
    $mysqli->escape_string($_GET["usr_email"]),    
    $mysqli->escape_string($_GET["usr_prof"]),    
    $mysqli->escape_string($_GET["usr_id"])    
);
if (!$result = $mysqli->query($query))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }
else{
    
    $redirect = "Location:user_login_update.php?username=".$_GET["username"]."&password=".$_GET["password"]. "";
    
    header($redirect); 
}
?>