<?php

session_start();
include_once("config.php");



if(isset($_GET["ord_conf"]))
{
    if(isset($_SESSION["active_user"]))
    {        
        $query = "SELECT MAX(order_no) FROM client_orders;";
        $results =  $mysqli->query($query);
        $max = $results->fetch_array(MYSQLI_NUM);
        $max[0] += 1;
        //MAX ORDER_NO TRACK

        foreach ($_SESSION["e-shop"] as $cart_itm)
        {
            //set variables to use in content below
            $prd_name =     $cart_itm["product_name"];
            $prd_quantity = $cart_itm["product_qty"];
            $prd_price =    $cart_itm["product_price"];
            $date =         date("j-n-Y");                
            $prd_code =     $cart_itm["product_code"];
            $usr_id =       $_SESSION["active_user"]["usr_id"];
            $order_no =     $max[0];

            $query = sprintf
            (  
               "INSERT INTO client_orders (prd_name ,prd_quantity, prd_price ,date, prd_code,usr_id, order_no)
               VALUES ('%s','%s','%s','%s','%s','%s','%s')",
               $mysqli->escape_string($prd_name),
               $mysqli->escape_string($prd_quantity),
               $mysqli->escape_string($prd_price),
               $mysqli->escape_string($date),
               $mysqli->escape_string($prd_code),
               $mysqli->escape_string($usr_id),
               $order_no
            );

            if (!$mysqli->query($query))
            {
                printf("Errormessage: %s\n", $mysqli->error);
            }
        }
        $order_no = $max[0];$order_date = date("j-n-Y");$order_status = "Pending";
        
        $query = sprintf
        (  
            "INSERT INTO order_history (order_no ,order_date, order_status)
            VALUES ('%s','%s','%s')",
            $mysqli->escape_string($order_no),
            $mysqli->escape_string($order_date),
            $mysqli->escape_string($order_status)
        );
         if (!$mysqli->query($query))
            {
                printf("Errormessage: %s\n", $mysqli->error); die;
            }
        unset($_SESSION["e-shop"]);
        $redirect = "index.php" ;
        goto redirect;
   }
   else{
    ?>                
    <script type="text/javascript">
    alert("You Need To Log-In First!");
    </script>
    <?php 
        $redirect = "my_account.php" ;
        goto redirect;
   }

}
    

if(isset($_GET["details_button"]))
{
    
if(isset($_SESSION))
{
    $_SESSION["tmp_product_code"] = $_GET["product_code"] ;
    $redirect = "details.php";
    goto redirect;
}
else{
    try {
        throw RuntimeException::showMsg("No Session going on!");
    }catch( RuntimeException $e){echo $e->getMessage();}       
}
}


//add product to session or create new one
if (isset($_GET["update_button"]) && $_GET["product_qty"]>0)
{
        foreach($_GET as $key => $value){ 
        //add all post vars to new_product array
        $new_product[$key] = strip_tags($value);
        }
	//remove unecessary vars
	unset($new_product['type']);
	unset($new_product['return_url']); 
	
    //we need to get product name and price from database.
    $statement = $mysqli->prepare("SELECT product_name, product_price FROM products WHERE product_code=? LIMIT 1");
    $statement->bind_param('s', $new_product['product_code']);
    
    if(!$statement->execute()){
        throw new RuntimeException("Executing Query Failed \n");
    }
    
    $statement->bind_result($product_name, $price);
	
	while($statement->fetch())
        {
        //fetch product name, price from db and add to new_product array
        $new_product["product_name"] = $product_name; 
        $new_product["product_price"] = $price;
        
        //if session var already exist
        if(isset($_SESSION["e-shop"]))
        {  
            if(isset($_SESSION["e-shop"][$new_product['product_code']])) //check item exist in products array
            {
                unset($_SESSION["e-shop"][$new_product['product_code']]); //unset old array item
            }
            
        }
        $_SESSION["e-shop"][$new_product['product_code']] = $new_product;
        }
        $redirect = $_GET["return_url"] ;
}

//update or remove items via product_code
if(isset($_GET["product_qty"]) || isset($_GET["remove_code"]))
{
        // free update item quantity in product session
	if(isset($_GET["product_qty"]) && is_array($_GET["product_qty"])){
		foreach($_GET["product_qty"] as $key => $value){
			if(is_numeric($value)){
				$_SESSION["e-shop"][$key]["product_qty"] = $value;
			}
		}        
       }
	//remove an item from product session via product_code
        if(isset($_GET["remove_code"]) && is_array(($_GET["remove_code"]))){
            foreach($_GET["remove_code"] as $key){
                unset($_SESSION["e-shop"][$key]);
            } 
        }
        $redirect = $_GET["return_url"] ;
}

redirect:
    echo "
        <script type=\"text/javascript\">
        window.location = '$redirect';
        </script>      
    ";
    
    
    
?>