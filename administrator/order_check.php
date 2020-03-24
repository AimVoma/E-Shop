<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
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
   <style>
        a.nav:link, a.nav:visited {
        display:block; float:left;height:36px;text-decoration:none;color:#fff;}
   </style>        
    
<title>INDEX</title>

<meta charset="UTF-8">
<link rel="stylesheet"  href="http://localhost/e-shop/style.css" />

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
    echo $HTML =<<<HTML
    <form id = "user_index" method="get" action="admin_logout.php">
    <p style="display:inline"><span style="color:#0e0e0e; font-size:115%; "> _ADMINISTRATOR_</span> <b> | </b></p>       
    <a href ="admin_logout.php?logout" style="font-size:115%;color:blue; "> Logout </a>
    </form>
HTML;
    ?>   
    </div>
    <div> 
    <div id="menu_tab">
      <ul class="menu">
          <li><a href="admin_account.php" class="nav">Admin's Account</a></li>
        <li class="divider"></li>
        <li><a href="index.php" class="nav">All Products</a></li>
        <li class="divider"></li>
        <li><a href="product_creation_form.php" class="nav" >Create New Product</a></li>
        <li class="divider"></li>
        <li><a href="orders_status.php" class="nav">Pending Orders</a></li>
      </ul>
    </div>
    
    
      
    <!-- end of menu tab -->
    <!------------------------------------------------------------------>

    <div class="left_content">
      <div class="title_box">Categories</div>
      <link href="style.css" rel="stylesheet" type="text/css"/>
      <ul class="left_menu">
        <li class="odd"><a href="#"><b>Engine Parts</b></a></li>
        <li class="even"><a href="#"><b>Braking Parts </b></a></li>
        <li class="odd"><a href="#"><b>Exhaust Parts</b></a></li>
        <li class="even"><a href="#"><b>Moto Accessories</b></a></li>
        <li class="odd"><a href="#"><b>Protective Gear</b></a></li>
      </ul>
    <!-- end of left content -->
    </div>
    <script type ="text/javascript">
    $(document).ready(function() {
        $('.left_menu ').css({"text-decoration":"line-through"});
        $('.left_menu li a').css({"color":"#000510"}); 
            $('.left_menu li').hover(		
               function () {
                  $(this).css({"text-decoration":"none"});
                  $(this).css({"background-image":"none"});
                }
            );
        });
      </script>
    
    <div class =" admin_tab_right">
        
 
    </div>
    
    
    
    <div class="center_content">
    <div id="oferta" style="margin:5px 0 5px 0;">
    <div>
        <img src="http://localhost/e-shop/images/image1.jpg" style="width:585px;">
    </div>
   <div>
        <img src="http://localhost/e-shop/images/image2.jpg" style="width:585px;">
   </div>
   </div>
    
    <div class="center_prod_content" style="border: 1px solid black ;padding-bottom:15px;border-color: #8e8a8d">  
    <h1 class="center_heading"> Pending Client Orders </h1>  
     <?php
        $order_status = 'Pending';
        $query = sprintf
        ("
            SELECT prd_name, prd_quantity, prd_price, date, order_history.order_no,prd_code
            FROM client_orders
            INNER JOIN order_history
            ON client_orders.order_no = order_history.order_no AND client_orders.order_no = '%s'
            WHERE order_history.order_status = '%s'
            ORDER BY client_orders.prd_code;
        ",  $mysqli->escape_string($_GET["order_no"]),
            $mysqli->escape_string('Pending')
        );
        if (!$result = $mysqli->query($query))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }       
        else
        {   
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        print $HTML=<<<HTML
            <table class = "orders">
            <tr style="background-color:lightblue; font-size:125%">
            <th>|Product Name|</th>
            <th>|Product Price|</th>		
            <th>|Product Qty|</th>
            <th>|Order Date|</th>
            </tr>
HTML;
        $query = sprintf
            ("
                SELECT product_quantity 
                FROM products
                INNER JOIN client_orders
                ON client_orders.prd_code = products.product_code
                WHERE client_orders.order_no = '%s'
                ORDER BY client_orders.prd_code;
            ",  $mysqli->escape_string($_GET["order_no"]));
        if (!$result = $mysqli->query($query))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }   
        $prd_qty_array = array();
        $i = 0;
        while($data_row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $prd_qty_array[$i++] = $data_row["product_quantity"];    
        }
  
        reset($prd_qty_array);
        $i=0;
       
        foreach($data as $row)
        {
            print $HTML=<<<HTML
            <tr>
            <td>{$row["prd_name"]}</td>
            <td> {$row["prd_price"]}&#8364 </td>
HTML;
            
            $prd_qty_array[$i] = intval($prd_qty_array[$i] - intval($row["prd_quantity"]));
            
            $td_color = ( $prd_qty_array[$i] >= 0 )? '<span style="color:green">':'<span style="color:red;font-size:12px;border:1px solid red;border-radius:5px;">';
            
            print $HTML=<<<HTML
            <td>{$td_color} {$row["prd_quantity"]} </span></td>
            <td> {$row["date"]} </td>
            </tr>
HTML;
            
            $i++;
        }
        echo '</table>';
        
        
        $serialized_data = serialize($prd_qty_array);

        
        print $HTML=<<<HTML
        <form method="get" action="order_management.php">;
        <input type="submit" name="order_no" style="float:right;border-radius:3px;width:150px " value="Discard" class="custom-button">;
        <input type="submit" name="order_ok" style="float:right;border-radius:3px;width:150px " value="Approve" class="custom-button">;
        <input type="hidden" name="serialized_data" value="{$serialized_data}" />;
        <input type="hidden" name="order_number" value="{$row["order_no"]}" />;
        </form> 
HTML;
        
     
        
        
        
        
        }
    ?>
      
    </div>
  <div class="footer">
      <div id="footer_logo"> HARIS MOTOS - All Rights Reserved 2015 </div>
  </div>

</div>
</div>
</div>
<!-- end of main_container -->

</body>
</html>