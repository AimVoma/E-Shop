<!DOCTYPE html>
<?php
session_start();
include_once "config.php";
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>

<?php
// This first query is just to get the total count of rows

$sql = "SELECT COUNT(id) FROM products ";
$query = $mysqli->query($sql);
$row = $query->fetch_array(MYSQLI_NUM);

// Here we have the total row count
$rows = $row[0];
// This is the number of results we want displayed per page
$page_rows = 6;
// This tells us the page number of our last page
$last = ceil($rows/$page_rows);
// This makes sure $last cannot be less than 1
if($last < 1){
	$last = 1;
}
// Establish the $pagenum variable
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['pn'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}
// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}
// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
// This is your query again, it is for grabbing just one page worth of rows by applying $limit

$sql = "SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC $limit";
$query =$mysqli->query($sql);

// Establish the $paginationCtrls variable
$paginationCtrls = '';
// If there is more than 1 page worth of results
if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
			}
	    }
        }
	// Render the target page number, but without it being a link
	$paginationCtrls .= '<span style="color:white; font-size:1.5em;">'.$pagenum.' </span>&nbsp; ';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
    }
}

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

    </div>
    <div> 
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="#" class="nav">My account</a></li>
        <li class="divider"></li>
        <li><a href="index.php" class="nav">Products</a></li>
        <li class="divider"></li>
        <li><a href="view_cart.php" class="nav">  Cart </a></li>
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
    <?php
    // INCLUDE THE ADD TO CART PHP SCRIPT
    include_once("addToCart.php");
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