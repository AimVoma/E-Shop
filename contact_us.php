<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = "index.php";
?>





<html>

<head>

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
    <div class="center_title_bar" style ="width:590px !important">Contact Us</div>
    <form action="index.php" method="get">
        <fieldset>
        <legend style="color:white; font-size:125% ; text-decoration: none">Please Leave Us Your Message  :</legend>
        <div class="contact_form">
            <div class="form_row">
              <label class="contact"><strong>Name:</strong></label>
              <input type="text" class="contact_input" />
            </div>
            <div class="form_row">
              <label class="contact"><strong>Email:</strong></label>
              <input type="text" class="contact_input" />
            </div>
            <div class="form_row">
              <label class="contact"><strong>Phone:</strong></label>
              <input type="text" class="contact_input" />
            </div>
            <div class="form_row">
              <label class="contact"><strong>Company:</strong></label>
              <input type="text" class="contact_input" />
            </div>
            <div class="form_row">
              <label class="contact"><strong>Message:</strong></label>
              <textarea class="contact_textarea" ></textarea>
            </div>
         <input type="submit" value="Submit Information" class="custom-button" style="width:262.5px;height:27.5px;font-size:125%;position:relative;left:34%;margin-top:10.5px;">    
        </fieldset>
    </form>
      
      <!------------------------------------------------------------------>
      
    
      
      
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