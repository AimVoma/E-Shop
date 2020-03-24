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
        
        <script>
        /*(function(){
            
        var vtext = document.getElementsByTagName('h1')[0] ;
        vtext.innerHTML = '<span>' + vtext.innerHTML.split('').join('</span><span>') + '</span>' ;
        })();*/
        </script>
        
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
    echo $HTML=<<<HTML
    <form method="get" action = "create_product.php" enctype="multipart/form-data">

    
    <fieldset>
    <legend style="color:white; font-size:125% ; text-decoration: none"> Στοιχεία Προς Δημιουργία καινούργιου Προιόντος :</legend>
    <div class="form_row">
    <label class="contact"><strong>Όνομα Προιόντος:</strong></label>
    <input type="text" name ="p_name" class="contact_input" />
    </div>
    <div class="form_row">
    <label class="contact"><strong>Κατηγορία Προιόντος:</strong></label>
    <input type="text" name ="p_cat" class="contact_input" />
    </div>
    <div class="form_row">
    <label class="contact"><strong>Διαθεσημότητα Προιόντος:</strong></label>
    <input type="text" name ="p_ava" class="contact_input" />
    </div>
    <div class="form_row">
    <label class="contact"><strong>Εγγύηση Προιόντος:</strong></label>
    <input type="text" name ="p_warr" class="contact_input" />
    </div>
    <div class="form_row">
    <label class="contact"><strong>Τύπος Μεταφοράς:</strong></label>
    <input type="text" name ="p_trans" class="contact_input" />
    </div>
    <div class="form_row" >
    <label class="contact"><strong>Περιγραφή Προιόντος:</strong></label>
    <textarea name = "p_desc" style="max-width:190px;min-height:55px" ></textarea>
    </div>
     <div class="form_row">
    <label class="contact"><strong>Τιμή Προιόντος:</strong></label>
    <input type="text" name="p_price" style="maxlength:"2"; size="2" " />
    </div>       
    </fieldset>
    
    <fieldset>
    <legend style="color:white; font-size:125% ; text-decoration: none"> Επιλέξτε Την Εικόνα Προιόντος:</legend>

    <label class="contact" style="display:inline;padding-left:70px"><strong>Εικόνα:</strong></label>
    <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left:42.5px">
    </fieldset>
   
            
    <input type="submit" name="info_submit" value="Submit Information" class="custom-button" style="width:582.5px;height:25px;font-size:125%;text-decoration:none">
    <input type="hidden" name ="url" value="$current_url">
    </form>
HTML;
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