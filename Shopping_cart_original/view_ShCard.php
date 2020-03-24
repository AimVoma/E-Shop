<!DOCTYPE html>

<?php
session_start();
include_once "config.php";
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>

<html>

<head>

<title>INDEX</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet"  href="style.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#oferta > div:gt(0)").hide();

setInterval(function() { 
  $('#oferta > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('#oferta');
},  3000);

});
</script>




</head>

<body>
<div id="wrapper">
    <div id=header>
    <img id="header_image" src="images/logo.png">
    

    </div>
    <div> 
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="#" class="nav">My account</a></li>
        <li class="divider"></li>
        <li><a href="index.php" class="nav">Products</a></li>
        <li class="divider"></li>
        <li><a href="products1.html" class="nav">  Cart </a></li>
        <li class="divider"></li>
        <li><a href="contact_us.html" class="nav">Contact Us</a></li>
        <li class="divider"></li>
        <li><a href="newsletter.html" class="nav">Newsletter</a></li>
      </ul>
    </div>
    
    
      
    <!-- end of menu tab -->
    <!------------------------------------------------------------------>

    <div class="left_content">
      <div class="title_box">Categories</div>
      <link href="style.css" rel="stylesheet" type="text/css"/>
      <ul class="left_menu">
        <li class="odd"><a href="left_menu1.html"><b>Engine Parts</b></a></li>
        <li class="even"><a href="#"><b>Braking System </b></a></li>
        <li class="odd"><a href="#"><b>Transmission System</b></a></li>
        <li class="even"><a href="#"><b>Forward Complex</b></a></li>
        <li class="odd"><a href="#"><b>Refinishing Products</b></a></li>
      </ul>
    <!-- end of left content -->
    </div>
    
    <?php
      if(isset($_SESSION))
          {
            $total_prc = 0;$total_qty = 0;
            if(isset($_SESSION["e-shop"]) && count($_SESSION['e-shop']>0))
            {
            $total_prc = Calc($_SESSION['e-shop'])['price']  ;  
            $total_qty = Calc($_SESSION['e-shop'])['qty'] ;   
            }
            echo $HTML_ = <<<HTML
                    <div class="right_content">
                    <div class="border_box">
                        <input type="text" name="Search"  value="Search..." maxlength="12" size = "12"  >
                        <input type="button" value="Search">
                    </div>
                    <form method="post" action="view_cart.php"
                    <div class="shopping_cart">
                      <div class="title_box">Shopping cart</div>
                      <div class="cart_details"> {$total_qty} items <br />
                        <span class="border_cart"></span> Total: <span class="price">{$total_prc}&nbsp&nbsp{$currency}</span> </div>
                      <div class="cart_icon"><input type="image" src="images/shoppingcart.png"width="35" height="35" border="0" ></div>
                    </div>
                         </form>      
                    </div>
HTML;
            
          }
      ?>
    <?php
        function Calc(array $temp_array){
            $tmp = array(
                'price' => 0.0,
                'qty' =>0.0,
                );
            
            foreach($_SESSION['e-shop'] as $prod_object)
            {
              for($i = 0 ; $i < intval($prod_object["product_qty"]);$i++)
              {
                  $tmp['price'] = $tmp['price'] + floatval($prod_object["product_price"]);
              } 

              $tmp['qty']= $tmp['qty'] + floatval($prod_object["product_qty"]);
            }
            return $tmp;
        
            }
    ?>
    
    <div class="center_content">
    <div id="oferta">
	<div>
     <img src="images/image1.gif">
   </div>
   <div>
     <img src="images/image2.jpg">
   </div>
    </div>
    
    <div class="center_prod_content">    
    <div class="cart-view-table-back">
<form method="post" action="cart_update.php">
<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Remove</th></tr></thead>
  <tbody>
 	<?php
	if(isset($_SESSION["e-shop"])) //check session var
    {
		$total = 0; //set initial total value
		$b = 0; //var for zebra stripe table 
		foreach ($_SESSION["e-shop"] as $cart_itm)
        {
			//set variables to use in content below
			$product_name = $cart_itm["product_name"];
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["product_price"];
			$product_code = $cart_itm["product_code"];
			$subtotal = ($product_price * $product_qty); //calculate Price x Qty
			
		   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe 
                        echo '<tr class="'.$bg_color.'">';
			echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" readonly="" /></td>';
			echo '<td>'.$product_name.'</td>';
			echo '<td>'.$currency.$product_price.'</td>';
			
			echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
                        echo '</tr>';
			$total = ($total + $subtotal); //add subtotal to total var
        }
	}
    ?>
    <tr><td colspan="5"><span style="float:right;text-align: right;"> Amount Payable : <?php echo $total.'&nbsp'. $currency?> </span></td></tr>
    <tr><td colspan="5"><a href="index.php" class="button">Add More Items</a> <input type="submit" value="Update" class="custom-button"></td></tr>
  </tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />
</form>
</div>    
        
        
        

      
    
      
      
        
      
    <!-- end of right content -->
   </div>
  <!-- end of main content -->
  </div>
  <div class="footer">
      <div id="footer_logo"> HARIS MOTOS - All Rights Reserved 2015 </div>
  </div>

</div>
</div>    
<!-- end of main_container -->


</body>
</html>