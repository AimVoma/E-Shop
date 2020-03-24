<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
include_once "pagination.php";
?>





<html>

<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
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
    
    <div class="center_prod_content" style="border: 1px solid black ;padding-bottom:25px;border-color: #8e8a8d">  
        
    <h1 class="center_heading"> Order Status </h1>;    
    <?php 
        $query = sprintf
        ("
            SELECT *
            FROM order_history
            WHERE order_status = '%s'
        ",  $mysqli->escape_string("Pending")
        );
        if (!$result = $mysqli->query($query))
        {
            printf("Errormessage: %s\n", $mysqli->error);
        }
        if(mysqli_num_rows($result) == 0)
        {
        ?>
            <script type="text/javascript">
            window.alert("Currently No Orders !");
            </script>  
        <?php
        goto redirect;
        
        
        }
        
        $data = NULL ;
        $counter = 0;
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
                $data[] = $row ;
        foreach($data as $row )
        {
           $array[$counter][] = $row["order_no"];
           $array[$counter][] = $row["order_date"];
           $array[$counter][] = $row["order_status"];
            
            $counter++;
        }
     
        
        print $HTML=<<<HTML
            <table style="width:100%; background-color:grey;border-radius:7.5px">
            <tr style="background-color:lightblue; font-size:125%">
            <th>|Order Number|</th>
            <th>|Date|</th>		
            <th>|Status|</th>
            </tr>
HTML;
        for( $i = 0 ; $i< $counter ; $i++)
        {  
            print $HTML=<<<HTML
            <tr>
            <td> Order No [ {$array[$i][0]} ] </td>
            <td> {$array[$i][1]} </td>
            <td><b><span style="color:#e60000 ; font-size:105%"> {$array[$i][2]} </b></span></td>
            </tr>
HTML;
        }
        $orderNO = $array[0][0];
        echo '</table>' ;
        print $HTML=<<<HTML
        <form method="get" action="order_check.php">
        <input type="submit" name="order_check" style="float:right;border-radius:3px;width:250px " value="Continue To Details..." class="custom-button">
        <input type="hidden" name="order_no" value="{$orderNO}" />
        </form>
HTML;
    
        
  
        
redirect:        
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