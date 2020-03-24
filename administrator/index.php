<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
$current_url = "index.php";
?>





<html>

<head>
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
    
    <div class="center_prod_content">    
    <?php
    // INCLUDE THE ADD TO CART PHP SCRIPT
    //Paginate("SELECT COUNT(id) FROM products ","SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");
    Paginate("SELECT COUNT(p_id) FROM products ","SELECT * FROM products ORDER BY p_id ASC");
    ?>

        
      <?php
      if(isset($_SESSION))
      {
      echo '<script type="text/javascript"> createCheckbox();  </script>';
      echo '<h1 class="center_heading"> All Database Products </h1>';
      while($obj = $query->fetch_array(MYSQLI_ASSOC))
      {
      

     echo '<div class="prod_box">';
     echo '<form id="admin_form" method="get" action="admin_controls.php">';
     ?>
     
    <script>
    function createCheckbox()
    {
        var pagin_ctr = <?php echo $_SESSION["admin_pag_ctr"]=$_SESSION["admin_pag_ctr"] + 1;?> ;
        return '<input type="checkbox" ID="Checkbox' + pagin_ctr +'" />' ;
        
    }  
    
    document.write(createCheckbox()); 
    </script>
        
       <?php
$product_obj=<<<HTML
        <div class="center_prod_box">
          <div class="product_title"> {$obj["product_name"]} </div>
          <div class="product_img"><a href="#"><img src="http://localhost/e-shop/images/{$obj["product_img_name"]} " alt="" border="0" style="width:94px;height:71px;" /></a></div>
         <label>
		<span style="color:#fff;font-weight: bold;visibility: hidden;">Quantity</span>
		<input type="text" style="visibility: hidden;" size="2" maxlength="2" name="product_qty" value="1" />
	</label>
        <div class="prod_price"><span class="price">{$currency}&nbsp{$obj["product_price"]}</span></div>
        

        
        <input type="hidden" id="skata" name="product_code" value="{$obj["product_code"]}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
        <input type="hidden" name="delete_pid" value="skata" id="del_input" />
        </div>
        </form>

      </div>
HTML;
      echo $product_obj ;
      }
      echo  '<div id="pagination_controls">'. $paginationCtrls ."</div>";
      }

    ?>
    
    
<script> 

function redirect( pid ){document.getElementById("del_input").value = pid;}

$('#Checkbox1').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 1;
       }
        else
        {
           var pid = 1 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
        }
    redirect(pid);
    }
});
$('#Checkbox2').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 2;
       }
        else
        {
           var pid = 2 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
        }
    redirect(pid);
    }
});
$('#Checkbox3').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 3 ;
       }
        else
        {
           var pid = 3 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
        }
    redirect(pid);
    }
});
$('#Checkbox4').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 4;
       }
        else
        {
           var pid = 4 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
           redirect(pid);
        }
    redirect(pid);
    }
});
$('#Checkbox5').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 5;
       }
        else
        {
           var pid = 5 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
           redirect(pid);
        }
    redirect(pid);
    }
});
$('#Checkbox6').change(function () {
    if ($(this).is(":checked")) {
       var href = window.location.href ;
       
       if(!href.split("index.php")[1]){
           var pid = 6;
       }
        else
        {
           var pid = 6 + ((parseInt(href.split("pn=")[1]) - 1) * 6);
        }
    redirect(pid);
    }
});







</script>
      
      
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
        <div class =" admin_tab_left">
            <input type="submit" form="admin_form" class="custom-button" style="width:150px;height:100%;" value ="Delete Product"/>
            <script type = "text/javascript" language = "javascript">
            $(document).ready(function() {

            $('.custom-button').hover(
				
               function () {
                  $(this).css({"text-decoration":"line-through"});
               }, 
				
               function () {
                  $(this).css({"text-decoration":"none"});
               }
            );
				
         });
      </script>
                
        
    </div>>
  <div class="footer">
      <div id="footer_logo"> HARIS MOTOS - All Rights Reserved 2015 </div>
  </div>

</div>
</div>    
<!-- end of main_container -->


</body>
</html>