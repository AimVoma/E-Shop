<?php
session_start();
include_once "config.php";

$count = $mysqli->query("SELECT COUNT(p_id) FROM products ");
$count = $count->fetch_array(MYSQLI_NUM);
$max_products = $count[0] ;
 
//print_r($_GET); die;


$p_id = $max_products + 1 ;
//$p_code = $mysqli->real_escape_string("PD".$p_id);

$p_name = $mysqli->real_escape_string($_GET["p_name"] );
$p_cat = $mysqli->real_escape_string($_GET["p_cat"] );
$p_ava = $mysqli->real_escape_string($_GET["p_ava"] );
$p_warr = $mysqli->real_escape_string($_GET["p_warr"] );
$p_trans = $mysqli->real_escape_string($_GET["p_trans"] );
$p_desc = $mysqli->real_escape_string($_GET["p_desc"] );
$p_price = $mysqli->real_escape_string($_GET["p_price"] );
$p_img = $mysqli->real_escape_string($_GET["fileToUpload"]);
$p_img = 'new_products/'. $p_img ;




$sql = "SELECT MAX(product_code) as max FROM products;";

$query = $mysqli->query($sql);
$max_pcode=$query ->fetch_assoc();
$max_pcode = $max_pcode["max"];

$max_pcode = filter_var($max_pcode, FILTER_SANITIZE_NUMBER_INT);
$max_pcode+=1;

$p_code = $mysqli->real_escape_string("PD".$max_pcode);



$sql = "INSERT INTO products 
(   
    p_id,  product_code , 
    product_name ,product_category,product_availability , 
    product_warranty ,product_transport,
    product_desc,product_price,product_img_name
)
VALUES
(
    '$p_id', '$p_code',
    '$p_name', '$p_cat', '$p_ava',
    '$p_warr', '$p_trans',
    '$p_desc','$p_price','$p_img'
)";

if(!$mysqli->query($sql))
    echo("Error description: " . $mysqli->error);

header("Location:index.php");