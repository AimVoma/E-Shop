<?php
session_start();
include_once "config.php";
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>




<!DOCTYPE html>
<html>

<head>

<title>Details</title>
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
    <div id="content"> 
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
       <ul class="left_menu">
        <li class="odd"><a href="engine_parts.php"><b>Engine Parts</b></a></li>
        <li class="even"><a href="braking_parts.php"><b>Braking Parts </b></a></li>
        <li class="odd"><a href="exhaust_parts.php"><b>Exhaust Parts</b></a></li>
        <li class="even"><a href="moto_parts.php"><b>Moto Accessories</b></a></li>
        <li class="odd"><a href="gear_parts.php"><b>Protective Gear</b></a></li>
      </ul>
    
    </div>
    <!-- end of left content -->    
                
    <!-- Center Content -->
      <div class="center_content">
          
          
    <div id="oferta" style="margin:5px 0 5px 0;">
    <div>
        <img src="images/image1.jpg" style="width:585px;">
    </div>
   <div>
        <img src="images/image2.jpg" style="width:585px;">
   </div>
      </div>
      
       
<?php
$prod_found = false;
$query_result =  $mysqli->query( "SELECT * FROM products ORDER BY P_ID ASC ") ;
while($obj = $query_result->fetch_array(MYSQLI_ASSOC))
{
    if(isset($_GET["search"]))
        {
            if($_GET["search"] === "Search...")
            {
                $prod_found = false ; 
                break;
            }
            if($obj["product_name"] === trim($_GET["search"]))
            {
               $prod_found = true ;
               break;
            }
            else
               continue;
        }
    
    else if($obj["product_code"] == $_SESSION["tmp_product_code"])
    {
        $prod_found = true ;
        break;
    }
      
}    //IF PRODUCT NOT FOUND IN SEARCH !
      if(!$prod_found)
      {
        echo " <img src=\"images/productnotfound.png\" style=\"width:585px;height:228px;margin-top:15%;border:1px solid black \">     ";
          
      }
   else{
      echo $HTML =<<<HTML_ENTITIES
      <div class="center_title_bar"><span class ="white">{$obj["product_name"]}</span></div>
      <div class="prod_det">
          <div class = "prod_image"> 
          <a class="thumb" href="#"><img src="images/{$obj["product_img_name"]}  " alt=""  width="95" height="95" border="2" color:black solid>
          <span><img src="images/{$obj["product_img_name"]}" alt="" width="200" height="200"></span></a>
          </div>
          <table class = "prod_details"  >
            <tr>
              <td class = "td1" >Διαθεσημότητα </td>
              <td class = "td2" colspan ="2"> <span class ="white">{$obj["product_availability"]}</span></td>		
            </tr>
            <tr>
               <td class = "td1">Χρόνος Εγγυησης  </td>
               <td class = "td2" colspan ="2"><span class ="white">{$obj["product_warranty"]}</span></td>		
            </tr>
            <tr>
              <td class = "td1">Τρόπος Μεταφορας  </td>
              <td class = "td2" colspan ="2"><span class ="white">{$obj["product_transport"]}</span></td>		
            </tr>
            <td class="td1"><label>Περιγραφή Προιόντος:</label></td>
              <td><textarea style="align:center;resize:none;width:75%;height:100%;background:url(images/prod_details_bg.jpg); color:white;height:95%" readonly >{$obj["product_desc"]}</textarea></td>
            </tr>
             <tr>
              <td class = "td1">Τιμή Προιόντος </td>
              <td colspan ="2"> <span class="price" style="font-size:125%">{$obj["product_price"]}{$currency}</span> </td>		
            </tr>
            </table>
            <input type="submit" value="Zoom Over !" class="custom-button" style="position:relative; bottom:35px;left:20px;">
      </div>
HTML_ENTITIES;
   }
      
      ?>
      
      
      </div>  
        
        
    <!-- end of center content -->
      
      
      <!------------------------------------------------------------------>
      
      

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
  
  <!-- end of main content -->
  <div class="footer">
      <div id="footer_logo"> HARIS MOTOS - All Rights Reserved 20015 </div>
  </div>
<!-- end of main_container -->
</body>
</html>
