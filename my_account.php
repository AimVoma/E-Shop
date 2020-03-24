<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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
                    <div class="right_content" style="">
                    <div class="border_box" >
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
HTML;
                    if(isset($_SESSION['active_user']))
                    {    
                    
                        echo $HTML_ = <<<HTML
                        <div class ="usr_history">
                            <span style="display:block; color:lightblue; font-size:115% "><b> Order History </b></span>
                            <img src="images/order_history.png" onclick = "Redirect()" >
                        </div>
HTML;
                    }
                    echo '</div>';
                    echo '</form>';    
                    echo '</div>';     
                    

            
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
    if(isset($_SESSION["active_user"]))
    {  
        echo $HTML = <<<HTML
     
       <form method="get" action="user_info_update.php">;
       <table id = "form_" >
        <thead> <th style="background-color:lightblue;font-size:125%;border:1px solid #fff;border-radius :5px;text-decoration:underline;line-height:25px;"> User Account Information  <th> </thead>
        <tbody>
          <tr>
              <td> <b> Name :</b> <input type="text" style="margin-left:45px" name="usr_name" value = "{$_SESSION["active_user"]["name"]}">  </td>
          </tr>
          <tr>
            <td><b>  Surname :</b> <input type="text" style="margin-left:20px" name="usr_sname" value = "{$_SESSION["active_user"]["sname"]}"></td>
          </tr>
          <tr>
            <td><b>  Phone :</b>  <input type="text" style="margin-left:43px" name="usr_phone" value = "{$_SESSION["active_user"]["phone"]}"></td></td>
          </tr>
          <tr>
            <td><b>  Adress :</b> <input type="text" style="margin-left:40px" name="usr_adress" value = "{$_SESSION["active_user"]["adress"]}"></td>
          </tr>  
          <tr>
            <td><b>  Postal Code :</b> <input type="text" name="usr_postal_code" value = "{$_SESSION["active_user"]["postal_code"]}"></td>
          </tr>
          <tr>
            <td><b>  E-mail :</b> <input type="text" style="margin-left:50px" name="usr_email" value = "{$_SESSION["active_user"]["email"]}"></td>
          </tr>
          <tr>
            <td><b> Proficiency :</b>  <input type="text" name="usr_prof" style="margin-left:10px" value = "{$_SESSION["active_user"]["proficiency"]}"></td></td>
          </tr>  
        </tbody>
      </table>
    <input type="submit" name="update_client_info" style="position:relative;left:164px;border-radius:3px;width:310px " value="Update Info" class="custom-button">;  ;
    <input type="hidden" name="usr_id" value="{$_SESSION["active_user"]["usr_id"]}" />;
    <input type="hidden" name="url" value="{$current_url}" />;
    <input type="hidden" name="username" value="{$_SESSION["active_user"]["username"]}" />;
    <input type="hidden" name="password" value="{$_SESSION["active_user"]["password"]}" />;
   </form>
HTML;
            
    }  
    else
    { 
    echo $HTML=<<<HTML
    <form method="get" action = "user_login_update.php">
    <fieldset>
    <legend style="color:white; font-size:125% ; text-decoration: none"> User Login :</legend>
    <div class="form_row">
    <label class="contact"><strong>*Username:</strong></label>
    <input type="text" name="username" class="contact_input" />
    </div>
    <div class="form_row">
    <label class="contact"><strong>*Password:</strong></label>
    <input type="password" name="password" class="contact_input" />
    </div>     
    </fieldset>
    <input type="submit" name="info_submit" value="Submit Information" class="custom-button" style="width:150px;height:25px;font-size:125%; float:right ">   
    </form>
HTML;
    }
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


<script type="text/javascript">
    function Redirect(){
            window.location.href = 'user_history.php'; 
    }
    
    
</script>