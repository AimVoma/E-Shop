<?php
session_start();
include_once "config.php";

$p_id = $_GET["delete_pid"];


$sql = "DELETE FROM products WHERE p_id=".$p_id;

if($mysqli->query($sql) === True)
{   
    $MYSQLI_SORT_QUERY=<<<SQLQUERY
    update products
    set p_id = p_id-1
    where p_id > {$p_id} and p_id < 50
    order by p_id ASC;
SQLQUERY;
    
    if(!$mysqli->query($MYSQLI_SORT_QUERY))echo $mysqli->error;;
    
    
}
header('Location:index.php');