<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = "order_form.php";
?>





<html>

<head>

<title>Order Form</title>

<meta charset="UTF-8">
<link rel="stylesheet"  href="style.css" />
<script type="text/javascript" src="css-pop.js"></script>


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
    
    <script type="text/javascript">
    
    function JS()
    { 
        var bool =  (document.getElementById('payment_method').value == 'paypal')? true:false;
        if(bool)
            popup('popUpDiv');

    }
    
    </script>
        
    <div id="blanket" style="display:none;"></div>
	
        <div id="popUpDiv" style="display:none;">
        <image src =" images/paypal.png" style="width:400px; height:100px" > 
        
	
        
        
        <h1 style="font-size:15px; text-align:center ; display:inline ; padding-left:5px;"> Credit Card Number : </h1>
        <input type="text" value="----/ ----/ ----/ ----/" style="min-height:17.5px;padding-left:7.5px"> <button style="clear:both;height:22.5px " onclick="alert('Card Number Verified!');"> Check </button>
       
        <h1 style="padding-left:7.5px;font-size:15px; float:left; padding-top:20px;padding-right:15px;position:relative;">Credit Card Security Code : </h1>
        <input type="text" value="CVV" style=" margin-top:26px;max-width:95px;min-height:17.5px;">
        <p style="padding-left:7.5px;font-style: italic;line-height:10px; position:absolute;float:left; width:115px ;word-wrap:break-word;clear:both;padding-bottom:auto;">( Is a 3 or 4 digit number that presents in a back of your credit card! )</p>
        
        <h1 style="margin-top:50px;padding-left:7.5px;font-size:15px; float:left; padding-right:15px;clear:left;clear:top;">Expiery Date : </h1>
        <input type="text" value="MM/NN/YY" style="float:left;margin-top:45px;max-width:95px;min-height:17.5px;clear:right">
        
        
        <h2 style="position:relative;margin-top:15px;padding-left:7.5px;font-size:15px; float:left; padding-right:15px;clear:left;clear:top;">Charge Adress Postal Code : </h2>
        <input type="text" value="Postal Code" style="float:left;margin-top:12.5px;max-width:95px;min-height:17.5px;clear:right">
        <p style="padding-left:7.5px;font-style: italic;line-height:10px; position:absolute;bottom:70px;float:left; width:115px ;word-wrap:break-word;clear:right">(Charge Adress Postal Code Of The Current Credit Card! )</p>
        <input type="submit" onclick="popup('popUpDiv')" name="submit_form" style="position:absolute;bottom:0px; width:400px; height:42.5px;border-radius:0px;" value="Conclude Payment!" class="custom-button">
        
      </div>	
 
<script> 
function flush_session(){<?php  unset($_SESSION["e-shop"]) ; ?> } 
</script>
 <?php
 try{
    if(!isset($_SESSION["active_user"]))
        throw new Exception("NO ACTIVE USER EXIST !") ;
 }catch (Exception $e){
      echo $e->getMessage();
      die;
 }   
 
 
 
    echo $HTML=<<<HTML
    <form method="get" action = "index.php">
        
    
        <fieldset>
        <legend style="color:white; font-size:125% ; text-decoration: none">Please Verify The Order Form  :</legend>
        <div class="form_row">
        <label class="contact"><strong>*Name:</strong></label>
        <input type="text" name ="name" value={$_SESSION["active_user"]["name"]} class="contact_input" />
        </div>
        <div class="form_row">
        <label class="contact"><strong>*Sname:</strong></label>
        <input type="text" name ="sname" value={$_SESSION["active_user"]["sname"]} class="contact_input" />
        </div>
        <div class="form_row">
        <label class="contact"><strong>*Phone:</strong></label>
        <input type="text" name ="phone" value={$_SESSION["active_user"]["phone"]} class="contact_input" />
        </div>
        <div class="form_row">
        <label class="contact"><strong>*Adress:</strong></label>
        <input type="text" name ="adress" value={$_SESSION["active_user"]["adress"]} class="contact_input" />
        </div>
        <div class="form_row">
        <label class="contact"><strong>*Postal Code:</strong></label>
        <input type="text" name ="pcode" value={$_SESSION["active_user"]["postal_code"]} class="contact_input" />
        </div>
        <div class="form_row">
        <div class="form_row">
        <label class="contact"><strong>Payment Method: </strong></label>
        <select id="payment_method" name = "payment" onchange="JS()">
        <option value="credits">Credits</option>
        <option value="paypal" name="saab" >Paypal</option>
        </select>        
        </div>             
        <div class="form_row">
        <input type="checkbox" name="accept" value="terms" checked><span style="color:lightgrey;font-size:125%"> I accept the user terms and conditions </span><br>
        </div>
        </fieldset>
        <input type="submit" name="info_submit" value="Submit Information" class="custom-button" onclick="flush_session(); " style="width:582.5px;height:25px;font-size:125%">
 
      </form>
HTML;
?>      
      
      
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