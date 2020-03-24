      <?php
      if(isset($_SESSION))
      {
      while($obj = $query->fetch_array(MYSQLI_ASSOC))
      {
      $product_obj=<<<HTML
      <div class="prod_box">
        <form action="cart_update.php" method="get" >
        <div class="center_prod_box">
          <div class="product_title"> {$obj["product_name"]} </div>
          <div class="product_img"><a href="#"><img src=" images/{$obj["product_img_name"]} " alt="" border="0" style="width:94px;height:71px;" /></a></div>
         <label>
		<span style="color:#fff;font-weight: bold">Quantity</span>
		<input type="text" size="2" maxlength="2" name="product_qty" value="1" />
	</label>
        <div class="prod_price"><span class="price">{$currency}&nbsp{$obj["product_price"]}</span></div>
        

        
        <input type="hidden" name="product_code" value="{$obj["product_code"]}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
        </div>
    
        <div class="prod_details_tab">
        <input type="submit" name="update_button" value="Add To Cart" class="custom-button">
        <input type="submit" name="details_button" value="Details" class="custom-button">
        </form>
         
        </div>
      </div>
HTML;
      echo $product_obj ;
      }
      echo  '<div id="pagination_controls">'. $paginationCtrls ."</div>";
      }
     ?>