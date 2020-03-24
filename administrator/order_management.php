<?php
session_start();
include_once "config.php";
include_once "pagination.php";



$order_status;
if($_GET["order_ok"]){
    
    $order_status = 'Verified';
    
    $arrayQ = unserialize($_GET["serialized_data"]);

    $query = sprintf
    ("
        SELECT prd_code 
        FROM client_orders
        WHERE order_no = '%s'
    ",  $_GET["order_number"]);
     if (!$result = $mysqli->query($query))
            {
                printf("Errormessage: %s\n", $mysqli->error);
            }
    $arrayPC = array();
    $i = 0 ;
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $arrayPC[$i++] = $row;
    }

    $max = sizeof($arrayQ);
    $i = 0;

    while( $i < $max)
    {
        $Q =$arrayQ[$i];
        $PC=$arrayPC[$i][0];

        $query = sprintf
        ("
            UPDATE Products
            SET product_quantity='%s'
            WHERE product_code='%s';

        ",
            $mysqli->escape_string($Q),
            $mysqli->escape_string($PC)
            );

         if (!$result = $mysqli->query($query))
            {
                printf("Errormessage: %s\n", $mysqli->error);
            } 
        $i++;
    }
}
else
{
    $order_status = 'Cancelled'; 
}
   
    $query = sprintf
    ("
        UPDATE order_history
        SET order_status='%s'
        WHERE order_no='%s';

    ",
        $mysqli->escape_string($order_status),
        $mysqli->escape_string($_GET["order_number"])
        );
    if (!$result = $mysqli->query($query))
    {
        printf("Errormessage: %s\n", $mysqli->error);
    }    


header("Location: http://localhost/e-shop/administrator/index.php");
?>

