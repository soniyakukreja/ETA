<?php if(!empty($product)){ 
//$cart = explode(',',$usercart['ids']);
	?>
<div class="col-md-3">
	<div class="productBox">
		<img src="<?php echo base_url('uploads/product_img/'); echo empty($product['prod_image'])?'img_product.png':$product['prod_image']; ?>" alt="Product">
		<div class="productDetail">
			<span><?php echo $product['product_sku']; ?></span>
			<h4><?php echo $product['product_name']; ?></h4>
			<b>$<?php echo $product['c_price']; ?></b>
			<div class="cartBtn">
				<?php if($product['c_price']>0){ ?>
					<a href="javascript:void(0);" class="addNew addtocart" data-val="<?php echo $product['prod_id']; ?>">Add to Cart</a><?php  
				}else{ ?>
					<a href="javascript:void(0);" class="addNew expressInt" data-val="<?php echo $product['prod_id']; ?>">Express Interest</a>
				<?php } ?>
				<a href="<?php echo site_url('shop/prod_detail/').encoding($product['prod_id']); ?>" class="veiwPro">View Product</a>
			</div>
		</div>
	</div>
</div>

<?php }  ?>