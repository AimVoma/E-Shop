<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = "index.php";
?>





<html>

<head>
<style type="text/css">
table.orders {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
        width:100%;
}
table.orders th {
	background:#b5cfd2 url('cell-blue.jpg');
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #999999;
        border-radius:1px;
}
table.orders td {
	background:#dcddc0 url('cell-grey.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
        border-radius:1px;
}
</style>
<title>INDEX</title>

<meta charset="UTF-8">
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
    <img id = "header_image" src="images/logo.png">
    <?php 
    if(isset($_SESSION["active_user"])){
    echo $HTML =<<<HTML

    <form id = "user_index" method="get" action="logout.php">
    <p style="display:inline"><span style="color:#0e0e0e; font-size:115%; "> User < {$_SESSION["active_user"]["name"]} > </span> <b> | </b></p>       
    <a href ="logout.php?logout" style="font-size:115%;color:blue; "> Logout </a>
    </form>
HTML;
    
    }        
    ?>        
    </div>
    <div> 
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="my_account.php" class="nav">My account</a></li>
        <li class="divider"></li>
        <li><a href=<?php
        if(isset($_SESSION["active_user"]))
            echo "# onclick=\"(alert('You Are Currently Logged In!'))\"; "; 
        else echo "register.php" ;
        ?> 
        class="nav">Register</a></li>
        <li class="divider"></li>
        <li><a href="index.php" class="nav">Products</a></li>
        <li class="divider"></li>
        <li><a href="view_cart.php" class="nav">  Cart </a></li>
        <li class="divider"></li>
        <li><a href="contact_us.php" class="nav">Contact Us</a></li>
      </ul>
    </div>
    
    
      
    <!-- end of menu tab -->
    <!------------------------------------------------------------------>

    <div class="left_content">
      <div class="title_box">Categories</div>
      <link href="style.css" rel="stylesheet" type="text/css"/>
       <ul class="left_menu">
        <li class="odd"><a href="engine_parts.php"><b>Engine Parts</b></a></li>
        <li class="even"><a href="braking_parts.php"><b>Braking Parts </b></a></li>
        <li class="odd"><a href="exhaust_parts.php"><b>Exhaust Parts</b></a></li>
        <li class="even"><a href="moto_parts.php"><b>Moto Accessories</b></a></li>
        <li class="odd"><a href="gear_parts.php"><b>Protective Gear</b></a></li>
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
                    <form method="get" action="details.php">
                        <input type="text" name="search"  value="Search..." maxlength="30" size = "12"  >
                        <button> Search </button>
                    </form>
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
    <div class="center_content">
    <div id="oferta" style="margin:5px 0 5px 0;">
    <div>
        <img src="images/image1.jpg" style="width:585px;">
    </div>
   <div>
        <img src="images/image2.jpg" style="width:585px;">
   </div>
      </div>
    
    <div class="center_prod_content">    
        <?php
        $query = sprintf
        ("
            SELECT prd_name, prd_quantity, prd_price, date
            FROM client_orders
            INNER JOIN order_history
            ON client_orders.order_no = order_history.order_no
            WHERE order_history.order_status = '%s' AND usr_id='%s'
            ORDER BY order_history.order_no DESC
            LIMIT 8;
        ",  
            $mysqli->escape_string('Verified'),
            $mysqli->escape_string($_SESSION["active_user"]["usr_id"])    
        );
        
        $result = $mysqli->query($query) ;
        if (!$result = $mysqli->query($query))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }
        else{
            print $HTML=<<<HTML
            <table class = "orders">
            <tr style="background-color:lightblue; font-size:125%">
            <th>|Product Name|</th>
            <th>|Product Price|</th>		
            <th>|Product Qty|</th>
            <th>|Order Date|</th>
            </tr>
HTML;
            echo '<h1 class="center_heading"> Order History </h1>';
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                echo '<tr>';
                foreach($row as $data)
                {
                    print $HTML=<<<HTML
                    <td> {$data} </td>
HTML;
                }     
                echo '</tr>';
            }
            
            
            echo '</table>';
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