<?php

session_start();
include_once("config.php");


function redirect($url, $statusCode )
{
   header('Location: ' . $url, true, $statusCode);
}



if(isset($_GET["details_button"]))
{
    
if(isset($_SESSION))
{
    $_SESSION["tmp_product_code"] = $_GET["product_code"] ;
    redirect("details.php" , 303);
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

}



//$return_url = (isset($_GET["return_url"]))?urldecode($_GET["return_url"]) : "Return URL not exist!"; //return url
$return_url = $_GET["return_url"] ;

echo "
        <script type=\"text/javascript\">
        window.location = '$return_url';
        </script>      
";
?>