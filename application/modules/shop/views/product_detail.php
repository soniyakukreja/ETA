<?php $this->load->view('include/header'); ?>
	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
								<?php $this->load->view('shop/shop_leftbar',array('prod_cat'=>$prod_cat)); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<div id="errorMsg" class="alert alert-danger <?php if(empty($product)){ echo 'show'; }else{ echo 'hide'; } ?>">
										  <strong><?php if(empty($product)){ echo 'Product is no Longer availble'; } ?></strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php 
										if(!empty($product)){ ?>
										<div class="producDetl">
											<div class="row">
												<div class="col-md-4">
													<div class="proImg">
														<img src="<?php echo base_url('uploads/product_img/'); echo empty($product['prod_image'])?'img_product.png':$product['prod_image']; ?>" alt="Product">
													</div>
												</div>
												<div class="col-md-8">
													<?php //echo "<pre>"; print_r($product); exit; ?>
													<a href="<?php echo site_url('shop'); ?>" class="veiwPro">Back to Shop</a>
													<div class="productDetail proPage">
														<span><?php echo $product['product_sku']; ?></span>
														<h4><?php echo $product['product_name']; ?></h4>
														<b>$<?php echo $product['c_price']; ?></b>
														<?php if(!empty($product['c_price'])){ ?>
														<div class="quality">
															<?php echo form_open('shop/update_cart',array('id'=>'updateCart')); ?>
															<input type="hidden" name="prodid[]" value="<?php echo $product['prod_id']; ?>">

															<span>Quantity</span>
															<button type="button" class="minusqty"><span class="glyphicon glyphicon-minus"></span></button>
															<input type="text" name="qty[]" class="qty" value="<?php echo empty($product['prod_qty'])?1:$product['prod_qty']; ?>">
															<button type="button" class="plusqty"><span class="glyphicon glyphicon-plus"></span></button>

															<?php if(in_array($product['prod_id'],explode(',',$usercart['ids']))){
															?><input type="submit" class="" id="update_cart" value="Update Cart"><?php 
															}else{ ?>
															<a href="javascript:void(0)" class="addNew addtocart" id="cartbtn" data-val="<?php echo $product['prod_id']; ?>"><?php echo empty($product['cart_id'])?'Add to Cart':'Added to Cart'; ?></a>														
															<input type="submit" class=""style="display:none;" id="update_cart" value="Update Cart">
															<?php } ?>
															<?php echo form_close(); ?>
														</div>
														<?php }else{ ?>
														<div class="quality">
															<a href="javascript:void(0);" class="addNew expressInt" data-val="<?php echo $product['prod_id']; ?>">Express Interest</a>
														</div>

														<?php } ?>
														<p><?php echo $product['prod_description']; ?>
														</p>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
									<!-- <div class="bannerDiv">
										<img src="<?php echo base_url('assets/img/asss_banner.png'); ?>" alt="Ads" />
									</div> -->
									<?php $this->load->view('include/rightsidebar'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
<?php $this->load->view('include/footer.php'); ?>
<?php $this->load->view('include/shop_js'); ?>
</div>
</body>
</html>

<script type="text/javascript">

$(document).on('click','.plusqty',function(){
	var qty = $(this).prev('.qty').val();
	var newqty = parseInt(qty)+1;
	$(this).prev('.qty').val(newqty);
	//changeButton();
});

$(document).on('click','.minusqty',function(){
	var qty = $(this).next('.qty').val();
	if(qty>1){
		var newqty = parseInt(qty)-1;
		$(this).next('.qty').val(newqty);
		//changeButton();
	}

});


$(document).on('change','.qty',function(){
	var qty = parseFloat($(this).val());
	if(qty<0 || isNaN(qty)){
		$(this).val('1');
	}
	//changeButton();
});

function changeButton(){
	$('#cartbtn').hide();
	$('#update_cart').show();
}

$(document).on('submit','#updateCart',function(e){

	e.preventDefault();
	var url = $(this).attr('action');
	var newdata = $('#updateCart').serialize();
	$.ajax({
		url: url,
		data: newdata,
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();

			$('#navCartTotal').html(res.qtytotal);

			if(res.success) {
				$(document).find('#cartmenu').show(); 
				$('#errorMsg').addClass('hide').removeClass('show');
				$('#successMsg').addClass('show').removeClass('hide').html(res.msg).fadeOut('slow');
				
				setTimeout( function(){ 
					$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					//window.location.reload();
				  }  , 10000 );
			}else{
				$(document).find('#cartmenu').hide(); 

				$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
				$('#successMsg').addClass('hide').removeClass('show');
				allIsOk = false;
			}
			$('html, body').animate({
			    scrollTop: $(".dashBody").offset().top			    
			}, 1000);
		}             
	});

});

</script>