<?php $this->load->view('include/header'); 
$audit = false;
if(!empty($products)){ foreach($products as $prod){ 
if($prod['type']=="Audit"){ $audit = true; }
 }}
 //echo "<pre>"; print_r($mydata); exit;
 //echo "<pre>"; print_r($mydata['business_id']); exit;
?>
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
								<div class="cartDetail">
									<div class="filterBody">
										<div class="filterDiv">
											<?php echo form_open('shop/checkout',array('class'=>'billingForm','id'=>'orderForm','autocomplete'=>'off','enctype'=>'multipart/form-data')); ?>
											
											<div id="addressDiv" class="divsec" style="display:block;">
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Billing Details</h3>
														<div>
															<div class="form-group required">
																<label>First Name </label>
																<input type="text" name="fname" id="fname" class="form-control" placeholder="Enter your first name" value="<?php echo $this->session->userdata['userdata']['firstname']; ?>">
																<span id="fname_err" class="invalidText"></span>
															</div>
															
															<div class="form-group required">
																<label>Last Name </label>
																<input type="text" name="lname" id="lname" class="form-control" placeholder="Enter your last name" value="<?php echo $this->session->userdata['userdata']['lastname']; ?>">
																<span id="lname_err" class="invalidText"></span>
															</div>
															<?php if($audit){ ?>
															<div class="form-group required">
																<label>Business Name </label>
																<input type="text" name="au_business" id="au_business" class="form-control" placeholder="Enter your Business Name" value="<?php echo $mydata['business_name']; ?>" onkeydown="event.preventDefault()">
																<span id="au_business_err" class="invalidText"></span>
															</div>
															<?php } ?>
															<div class="form-group required">
																<label>Email Address </label>
																<input type="email" name="email" id="email" class="form-control" placeholder="Enter your email Address" value="<?php echo $this->session->userdata['userdata']['email']; ?>">
																<span id="email_err" class="invalidText"></span>
															</div>
															<div class="form-group required">
																<label>Street Address </label>
																<input type="text" name="address" id="address" class="form-control" placeholder="Enter your street address">
																<span id="address_err" class="invalidText"></span>
															</div>
															<div class="form-group">
																<label>Street Address </label>
																<input type="text" name="alt_address" id="alt_address" class="form-control" placeholder="Enter your street address">
																<span id="alt_address_err" class="invalidText"></span>
															</div>															
															<div class="form-group required">
																<label>Suburb/Province </label>
																<input type="text" name="city" id="city" class="form-control" placeholder="Enter your Suburb/Province">
																<span id="city_err" class="invalidText"></span>
															</div>
															<div class="form-group">
																<label>State</label>
																<input type="text" name="state" id="state" class="form-control" placeholder="Enter your State">
																<span id="state_err" class="invalidText"></span>
															</div>
															<div class="form-group">
																<label>Post Code</label>
																<input type="text" name="postcode" id="postcode" class="form-control" placeholder="Enter Post Code">
																<span id="postcode_err" class="invalidText"></span>
															</div>
															<div class="form-group required">
																<label>Country </label>
																<div class="contr" >
																	<select class="js-example-basic-single" name="country" id="country">
																		<option value="">Please Select</option>
																		<?php if(!empty($countrylist)){ foreach($countrylist as $value){ ?>
																		<option  value="<?php echo $value['id']; ?>" <?php if($value['id']==$mydata['country']){ echo 'selected'; } ?> ><?php echo $value['country_name']; ?></option>
																		<?php } } ?>
																	</select>
																</div>
																<span id="country_err" class="invalidText"></span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Shipping Details</h3>
														<div>
														<div class="myBill form-group">
															<label>
																<input type="checkbox" name="ship_add_checkbox" id="ship_add_checkbox" value="1" checked="">
																<span></span>Ship to the same address?
															</label>
														</div>
														<div id="shipDiv" style="display:none;">
															<div class="form-group required">
																<label>Street Address </label>
																<input type="text" name="sh_address" id="sh_address" class="form-control" placeholder="Enter your street address">
																<span id="sh_address_err" class="invalidText"></span>
															</div>
															<div class="form-group">
																<label>Street Address </label>
																<input type="text" name="alt_shaddress" id="alt_shaddress" class="form-control" placeholder="Enter your street address">
																<span id="alt_shaddress_err" class="invalidText"></span>
															</div>																	
															<div class="form-group required">
																<label>Suburb/Province </label>
																<input type="text" name="sh_city" id="sh_city" class="form-control" placeholder="Enter your Suburb/Province">
																<span id="sh_city_err" class="invalidText"></span>
															</div>
															

															<div class="form-group required">
																<label>State </label>
																<input type="text" name="sh_state" id="sh_state" class="form-control" placeholder="Enter your State">
																<span id="sh_state_err" class="invalidText"></span>
															</div>
															

															<div class="form-group required">
																<label>Post Code </label>
																<input type="text" name="sh_postcode" id="sh_postcode" class="form-control" placeholder="Enter Post Code">
																<span id="sh_postcode_err" class="invalidText"></span>
															</div>
															

															<div class="form-group required">
																<label>Country </label>
																<div class="contr">
																	<select class="js-example-basic-single" name="sh_country" id="sh_country">
																		<option value="">Please Select</option>
																		<?php if(!empty($countrylist)){ foreach($countrylist as $value){ ?>
																			<option  value="<?php echo $value['id']; ?>"><?php echo $value['country_name']; ?></option>
																		<?php } } ?>
																	</select>
																</div>
																<span id="sh_country_err" class="invalidText"></span>
															</div>
															
														</div>
														<div class="form-group">
															<label>Additional Information</label>
															<div class="contr">
																<textarea name="add_info" id="add_info" class="form-control" cols="50" rows="100"></textarea>
															</div>
														</div>
													
														<?php if(!empty($add_ques)){ ?>
														<div class="payBtn form-group">
															<a class="addNew" href="javascript:void(0);" id="gotoadd_ques">Go to Additional Questions</a>															
														</div>
														<?php }else{ ?>
														<div class="payBtn form-group">
															<button class="addNew" id="confirmPayment" type="submit">Continue to Payment</button>
														</div>
														<?php } ?>
														<div class="payBtn">
															<a class="veiwPro" href="<?php echo site_url('shop/your_cart'); ?>">Back to Cart</a>
														</div>

														</div>
													</div>
												</div>
											</div>
											
											<div id="add_ques" style="display:none;" class="divsec">
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Additional Questions</h3>
														<div class="form_builder_area">
														<?php 
														if(!empty($add_ques)){ foreach($add_ques as $ques){
															echo $ques['frm_manager_fields'];
														} }
														?>
														</div>
															<div class="payBtn form-group">
																<button class="addNew" id="confirmPayment" type="submit">Continue to Payment</button>
															</div>
															<div class="payBtn">
																<a class="veiwPro" href="javascript:void(0)" id="gotoAddress">Back to Billing/Shipping Details</a>
															</div>
													</div>
												</div>
												<div class="col-md-4"></div>
											</div>
											
											<?php echo form_close();  ?>
											<div id="responceDiv" style="display:none;">
												<div class="col-md-4" id="msg"></div>
												<div class="col-md-4"></div>
											</div>
											<div class="col-md-4">
												<div class="bilDetail">
													<h3 class="shopCrt">Your Cart</h3>
													<div class="cartTable">
														<table>
															<tbody>
																<?php $carttotal = $dicountTotal=  0 ;
																if(!empty($products)){ 
																	
																foreach($products as $product){ 
																	if(!empty($product['prod_dis']) ){
																	?>
																	<tr>
																		<td>
																			<h4><?php echo $product['product_name']; ?></h4>
																			<span><?php echo $product['product_sku']; ?></span>
																			<br>
																			<b>Discount</b>
																		</td>
																		<td>
																			<?php 
																			$prodtotal = $product['c_price']*$product['prod_qty'];
																			$dis = round((($prodtotal*$product['prod_dis'])/100),2); $prodtotal-=$dis; ?>
																			<h4><b><?php echo $product['prod_qty']; ?> x <?php echo numfmt_format_currency($this->fmt,$product['c_price'], "USD"); ?></b></h4>
																			<br><br>
																			<b><?php echo numfmt_format_currency($this->fmt,$dis, "USD"); ?></b>
																		</td>
																	</tr>																
																	<?php 	
																	$dicountTotal += $dis;					
																	}else{ ?>
																	<tr>
																		<td>
																			<h4><?php echo $product['product_name']; ?></h4>
																			<span><?php echo $product['product_sku']; ?></span>
																		</td>
																		<td>
																			<?php $prodtotal = $product['c_price']*$product['prod_qty']; ?>
																			<h4><b><?php echo $product['prod_qty']; ?> x <?php echo numfmt_format_currency($this->fmt,$product['c_price'], "USD").' USD'; ?></b></h4><br>
																		</td>

																	</tr>
																	<?php }	?>

																<?php $carttotal += $prodtotal;  
																

																}} ?>

															</tbody>
														</table>
													</div>
													
													<div class="tcp">
													<table>
														<tbody>
															<tr>
																<td>
																	<h3>Card Total:</h3>
																	<h3>Discount Total:</h3>
																	<h3>Total:</h3>

																</td>
																<td>
																	<h3><?php echo numfmt_format_currency($this->fmt,$carttotal, "USD").' USD'; ?></h3>
																	<h3><?php echo numfmt_format_currency($this->fmt,$dicountTotal, "USD").' USD'; ?></h3>
																	<h3><?php 
																	$finalTotal = ($carttotal+$dicountTotal);
																	echo numfmt_format_currency($this->fmt,$finalTotal, "USD").' USD'; ?></h3>
																</td>

															</tr>
														</tbody>
														
													</table>
												</div>
												</div>
											</div>
											
										</div>
										<?php $this->load->view('include/rightsidebar'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<?php $this->load->view('include/footer'); ?>
</div>
</body>
</html>
<script>
$(document).on('click','#ship_add_checkbox',function(){
	if($(this).prop('checked')){
		$('#shipDiv').hide();
	}else{
		$('#shipDiv').show();
	}
});
function primaryvalidation(){
	allIsOk = true;
	var fname = $('#fname').val();
	var lname = $('#lname').val().trim();
	var email = $('#email').val().trim();
	var address = $('#address').val().trim();
	var city = $('#city').val().trim();
	var state = $('#state').val().trim();
	var postcode = $('#postcode').val().trim();
	var au_business_len = $('#au_business').length;
	
	var country = $('#country :selected').val().trim();

	var ship_add_checkbox = $('#ship_add_checkbox').prop('checked');

	var sh_address = $('#sh_address').val().trim();
	var sh_city = $('#sh_city').val().trim();
	var sh_state = $('#sh_state').val().trim();
	var sh_postcode = $('#sh_postcode').val().trim();
	var sh_country = $('#sh_country').val().trim();


	$('.invalidText').hide();
	if (fname == '') {
		$("#fname").focus();
		$("#fname_err").css('display','block').html('Please Enter First Name');
        allIsOk = false;
    }
    if(lname == ''){
		$("#lname").focus();
		$("#lname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }

    if(au_business_len>0){
		au_business = $('#au_business').val().trim();
	    if(au_business == ''){
			$("#au_business").focus();
			$("#au_business_err").show().html('Please Enter Business Name');
	        allIsOk = false;    	
	    }		
    }

    if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }
    if(address == ''){
		$("#address").focus();
		$("#address_err").show().html('Please Enter Address');
        allIsOk = false;  
    }
    if(city == ''){
		$("#city").focus();
		$("#city_err").show().html('Please Enter City');
        allIsOk = false;  
    }
    if(state == ''){
		$("#state").focus();
		$("#state_err").show().html('Please Enter State');
        allIsOk = false;  
    }
    if(postcode == ''){
		$("#postcode").focus();
		$("#postcode_err").show().html('Please Enter Post Code');
        allIsOk = false;  
    }
    if(country == ''){
		$("#country").focus();
		$("#country_err").show().html('Please Enter Country');
        allIsOk = false;  
    }

	if(ship_add_checkbox==false){

		if(sh_address == ''){
			$("#sh_address").focus();
			$("#sh_address_err").show().html('Please Enter Address');
	        allIsOk = false;  
	    }
	    if(sh_city == ''){
			$("#sh_city").focus();
			$("#sh_city_err").show().html('Please Enter City');
	        allIsOk = false;  
	    }
	    if(sh_state == ''){
			$("#sh_state").focus();
			$("#sh_state_err").show().html('Please Enter State');
	        allIsOk = false;  
	    }
	    if(sh_postcode == ''){
			$("#sh_postcode").focus();
			$("#sh_postcode_err").show().html('Please Enter Post Code');
	        allIsOk = false;  
	    }
	    if(sh_country == ''){
			$("#sh_country").focus();
			$("#sh_country_err").show().html('Please Enter Country');
	        allIsOk = false;  
	    }
	}
	return allIsOk ;

}

function add_validations(){
	var allIsOk = true ;
	$('#add_ques').find('.invalidText').css('display','none');
	$( ".add_field" ).each(function(){
		
		if($(this).prop('type')=='file'){
			var ds = $(this);
			if(ds.prop('required') && ds.val()==''){
				ds.parents('.form-group').find('.image_err').css('display','block').html('Please Upload file');
			}else{ 
				image_validation(this).then(function(){
					setTimeout(function() {

						is_valid = ds.attr('is_valid');
						if(is_valid==1){
							ds.parents('.form-group').find('.image_err').hide().html('');
						}else{
							allIsOk = false ;
						}

					}, 1000);
				});
			}
		}
		if($(this).prop('required') && $(this).prop('type')!='file' && $(this).val()==''){

			var placeholder = $(this).attr('placeholder'); 
			$(this).parents('.form-group').find('.invalidText').css('display','block').html('Please Enter '+placeholder);
			$(this).focus();	
			allIsOk = false ;
		}
	});

	var adddrop = $(".add_dropdown").length;
	if(adddrop>0){
		$(".add_dropdown").each(function(i,v) {
			if($(v).attr('required') && ($(this).val()=='' || $(this).val()<=0)){
				var placeholder = $(this).parent('.form-group').find('.control-label').html();
				$(this).parents('.form-group').find('.invalidText').html('Please Select '+placeholder).css('display','block');
				$(this).focus();	
				allIsOk = false ;
			}
		});
	}

	var add_radio = $(".add_radio").length;
	var radArr = [];
	if(add_radio >0){
		$(".add_radio").each(function(i,v){
			if($(v).attr('required')){
				if(!radArr.includes($(this).attr('name'))){
					radArr.push($(this).attr('name'));
				}
			}
		});
		radArr.forEach(function(i,v) {
			if(!$('input[name="'+i+'"]').is(':checked')){
				var placeholder = $('input[name="'+i+'"]').parents('.form-group').find('.control-label').html();
				$('input[name="'+i+'"]').parents('.form-group').find('.invalidText').html('Please Select '+placeholder).css('display','block');
				allIsOk = false ;
			}
			if(!allIsOk){ return false; }
		});
	}

	var add_check = $(".add_checkbox").length;
	var checkArr = [];
	if(add_check >0){
		$(".add_checkbox").each(function(i,v){
			if($(v).attr('required')){
				if(!checkArr.includes($(this).attr('name'))){
					checkArr.push($(this).attr('name'));
				}
			}
		});
		checkArr.forEach(function(i,v) {
			if(!$('input[name="'+i+'"]').is(':checked')){
				var placeholder = $('input[name="'+i+'"]').parents('.form-group').find('.control-label').html();
				$('input[name="'+i+'"]').parents('.form-group').find('.invalidText').html('Please Select '+placeholder).css('display','block');
				allIsOk = false ;
			}
			if(!allIsOk){ return false; }
		});
	}

	$( ".add_textarea" ).each(function() {
		if($(this).prop('required') && $(this).val()==''){
			var placeholder = $(this).attr('placeholder');
			$(this).parents('.form-group').find('.invalidText').html('Please Enter '+placeholder).css('display','block');
			$(this).focus();	
			allIsOk = false ;
		}
	});
	return allIsOk ;
}

$(document).on('click','#gotoadd_ques',function(e){
	e.preventDefault();
	if(primaryvalidation()){
		$('.divsec').hide();
		$('#add_ques').show();		
	}

});

/*
$(document).on('click','#gotopayment',function(){
	if(primaryvalidation() && add_validations()){
		$('.divsec').hide();
		$('#paymentDiv').show();
	}
});
*/

$(document).on('click','#gotoAddress',function(){
	$('.divsec').hide();
	$('#addressDiv').show();
});





$('#orderForm').on('submit',function(e){
    
	e.preventDefault();
	$('.invalidText').hide();
	var allIsOk = false;

	if(primaryvalidation() && add_validations()){
		var allIsOk = true;
	}
	
	if(allIsOk){
		ds = $(this);
		var formData = new FormData(ds[0]);

        $.ajax({
	        type: 'POST',
	        url: site_url+'shop/checkout',
	        data:formData,
	        processData: false,
		    contentType: false,	
	        dataType:'JSON',
	        success:(res)=>{
	          ajaxindicatorstop();
	          console.log(res); 
	            if(res.success) {
					window.location.href= res.redirect;
				}else{
					$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
					$('#successMsg').addClass('hide').removeClass('show');
					allIsOk = false;
				}

	        },
	        error:(res) => {
	        	ajaxindicatorstop();
	        	var error = res.responseJSON.error.message;
				$('#errorMsg').addClass('show').removeClass('hide').html(error);
				$('#successMsg').addClass('hide').removeClass('show');
	        }
	    });

	    //$('#confirmPayment').attr('disabled',true);
	    ajaxindicatorstart();

	    //create single-use token to charge the user

        
        //submit from callback
        return false;
	}else{
	    return allIsOk;
	}
})
$('#cvc').on('blur',function(){
    $('#confirmPayment').attr('disabled',false);
	if($(this).val() =='' || $(this).val().length !=3){
		$(this).addClass('borderR').focus();
        $("#cvc_msg").show();
	}else{
		$(this).removeClass('borderR');
        $("#cvc_msg").hide();		    
	}	    
})

$('#card_number').on('focusout',function(){
    $('#confirmPayment').attr('disabled',false);

	if($(this).val() =='' || $(this).val().length !=16){
		$(this).addClass('borderR').focus();
        $("#err_msg").show();
	}
})
$('#month, #year').on('change',function(){
    
    if($(this).val() >0){
    	$('#confirmPayment').attr('disabled',false);
    }
});
	

</script>

<script type="text/javascript">
//set your publishable key

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {

    if (response.error) {
        ajaxindicatorstop();
		$('#errorMsg').addClass('show').removeClass('hide').html(response.error.message);
		$('#successMsg').addClass('hide').removeClass('show');
        $('html, body').animate({
            scrollTop: $("#orderForm").offset().top
        }, 1000); 
    } else {
        
        var form$ = $("#orderForm");
        //get token id
        var token = response['id'];
        //insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        //submit form to the server

		var formData = new FormData(form$[0]);

        $.ajax({
	        type: 'POST',
	        url: site_url+'shop/checkout',
	        //data:form$.serialize(),
	        data:formData,
	         processData: false,
		    contentType: false,	
	        dataType:'JSON',
	        success:(res)=>{
	          ajaxindicatorstop();
	            if(res.success) {
					
					$('#orderForm')[0].reset();
					$('#ord_his_menu').show();
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('successful payment');
					
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
						window.location.href = site_url+'order-summary/'+res.order_id;
					  }  , 10000 );
				}else{
					$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
					$('#successMsg').addClass('hide').removeClass('show');
					allIsOk = false;
				}

	        },
	        error:(res) => {
	        	ajaxindicatorstop();
	        	var error = res.responseJSON.error.message;
				$('#errorMsg').addClass('show').removeClass('hide').html(error);
				$('#successMsg').addClass('hide').removeClass('show');
	        }
	    });
    }
}
$('#orderForm').disableAutoFill();

</script>