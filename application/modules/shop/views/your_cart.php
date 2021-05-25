<?php $this->load->view('include/header.php');
$carttotal = 0;
 ?>
 <style>
 	.expBtn .addNew {
 		position: initial;
 	}
 </style>
	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav.php'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
								<?php $this->load->view('shop/shop_leftbar',array('prod_cat'=>$prod_cat)); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<div class="yourCart">
											
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong></strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<h2>Your Cart</h2>
											<?php echo form_open('shop/update_cart',array('id'=>'update_andcheckout')); ?>
											<div class="cartTable">
												<table>
													<thead>
														<tr>
															<th>Product</th>
															<th>Price per Unit</th>
															<th>Quantity</th>
															<th>Total</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<?php if(!empty($products)){ 
															$carttotal = 0;
														foreach($products as $product){
															
														 ?>
														<tr>
															<td>
																<h4><?php echo $product['product_name']; ?></h4>
																<span><?php echo $product['product_sku']; ?></span>
															</td>
															<td>
																<b><?php echo numfmt_format_currency($this->fmt,$product['c_price'], "USD"); ?></b>
															</td>
															<td>
															<div class="et-cart">
																<input type="hidden" name="prodid[]" value="<?php echo $product['prod_id']; ?>">	
																<input type="hidden" name="price" class="price" value="<?php echo $product['c_price']; ?>">
																<button type="button" class="minusqty"><span class="glyphicon glyphicon-minus"></span></button>
																<input type="text" name="qty[]" class="qty" value="<?php echo $product['prod_qty']; ?>">
																<button type="button" class="plusqty"><span class="glyphicon glyphicon-plus"></span></button>
															</div>
															</td>
															<td>
																<?php $prodtotal = $product['c_price']*$product['prod_qty']; ?>
																<b class="prodprice"><?php echo numfmt_format_currency($this->fmt,$prodtotal, "USD"); ?></b>
															</td>
															<td>
																<div class="cartBtn">
																	<a href="javascript:void(0);" class="veiwPro removeProd" data-val="<?php echo $product['cart_id']; ?>" >Remove</a>
																</div>
															</td>
														</tr>
														<?php $carttotal += $prodtotal; }} ?>
														
													</tbody>
												</table>
											</div>
											<div class="totalCart expBtn">
												<p>Cart Total <span id="carttotal"><?php echo numfmt_format_currency($this->fmt,$carttotal, "USD"); ?></span></p>
												<?php if($carttotal>0){ ?>
													<a href="<?php echo site_url('shop/checkout'); ?>" class="addNew" id="checkoutbtn">Checkout</a>
													<input type="submit" class="addNew" id="update_checkoutbtn" style="display:none;" value="Update & Checkout" >
												<?php } ?>
											</div>
											<?php echo form_close(); ?>
										</div>
									</div>
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
<script>
$(document).on('click','.removeProd',function(){
	var cartid = $(this).data('val');
	var ds = $(this);
	$.ajax({
		url: site_url+'shop/remove_fromcart',
		data: ({cartid: cartid}),
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();
			if(res.success){

				$('#navCartTotal').html(res.qtytotal);
				ds.parents('tr').remove();
				calculate_carttotal();
				$('#success_head').css('display','block');
				$('#error_head').css('display','none');
			}else{
				$('#error_head').css('display','block');
				$('#success_head').css('display','none');

			}
			$('#msgbody').html(res.msg);
			$('#msg_modal').modal('show');
		}             
	});
});


/*
$(document).on('click','.updatePro',function(){
	var cartid = $(this).data('val');
	var qty = $(this).parents('tr').find('.qty').val();
	var prodid = $(this).data('prodid');
	var ds = $(this);
	$.ajax({
		url: site_url+'shop/updatecart',
		data: ({'cartid': cartid,'qty':qty,'prodid':prodid}),
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();
			if(res.success){
				calculate_carttotal();
				$('#success_head').css('display','block');
				$('#error_head').css('display','none');
			}else{
				$('#error_head').css('display','block');
				$('#success_head').css('display','none');
			}
			$('#msgbody').html(res.msg);
			$('#msg_modal').modal('show');
		}             
	});
});

*/

$(document).on('keyup','.qty',function(){
	var qty = $(this).val();
	var price = $(this).parents('tr').find('.price').val();
	if(isNaN(qty) || qty <=0){
		qty = 1;
		$(this).val(qty);

		$('#error_head').css('display','block');
		$('#success_head').css('display','none');

		$('#msgbody').html('Please add valid Quantity');
		$('#msg_modal').modal('show');

	}
	var prodprice = (parseFloat(price)*parseFloat(qty)).toFixed(2);
	$(this).parents('tr').find('.prodprice').html('$'+prodprice);

	calculate_carttotal();
});


$(document).on('click','.plusqty',function(){
	var qty = $(this).prev('.qty').val();
	var newqty = parseInt(qty)+1;
	$(this).prev('.qty').val(newqty);
	calculate_carttotal();
});

$(document).on('click','.minusqty',function(){
	var qty = $(this).next('.qty').val();
	if(qty>1){
		var newqty = parseInt(qty)-1;
		$(this).next('.qty').val(newqty);
		calculate_carttotal();		
	}

});

function calculate_carttotal(){
	var carttotal = 0;
	$('.qty').each(function(i,v){
		var qty = $(v).val();
		var price = $(v).parents('tr').find('.price').val();
		carttotal += parseFloat(qty)*parseFloat(price);
	});

	carttotal = parseFloat(carttotal).toFixed('2');
	$('#carttotal').html('$'+carttotal);

	if(parseFloat(carttotal)>0){ 
		$('#cartmenu').show(); 
		$('#checkoutbtn').hide();
		$('#update_checkoutbtn').show();
	}else{
		$('#cartmenu, #checkoutbtn, #update_checkoutbtn').hide(); 
	}
}

$(document).on('submit','#update_andcheckout',function(e){

	e.preventDefault();
	var url = $(this).attr('action');
	$.ajax({
		url: url,
		data: $('#update_andcheckout').serialize(),
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();

			if(res.success) {
				$('#errorMsg').addClass('hide').removeClass('show');
				$('#successMsg').addClass('show').removeClass('hide').html(res.msg).fadeOut('slow');
				
				setTimeout( function(){ 
					$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					window.location.href = site_url+'shop/checkout';
				  }  ,1000 );
			}else{
				$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
				$('#successMsg').addClass('hide').removeClass('show');
				allIsOk = false;
			}
			$('html, body').animate({
			    scrollTop: $(".dashBody").offset().top			    
			}, 1000);
		}             
	});

})

</script>