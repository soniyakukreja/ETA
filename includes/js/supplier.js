$(document).on('change','#supplier_email',function(){
	email = $(this).val();
	return check_emailexist(email);
});

$(document).on('submit','#add_supplier',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#supplier_fname').val().trim();
	var lastname = $('#supplier_lname').val().trim();
	var country = $('#supplier_country :selected').val().trim();
	var timezone = $('#timezone :selected').val().trim();
	var email = $('#supplier_email').val();
	var contactno = $('#phone').val();
	var business_name = $('#sup_business').val();
	var business_id = $('#business_id').val();

	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	// var user_cat_id = $('#user_cat_id').val();
	
	var pvalid = validate_pass($('#password'));

	$('.invalidText').hide();
	if (firstname == '') {
		$("#supplier_fname").focus();
		$("#supplier_fname_err").show().html('Please Enter First Name');
        allIsOk = false;
    }
    if(lastname == ''){
		$("#supplier_lname").focus();
		$("#supplier_lname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }
    if(country == ''){
		$("#supplier_country").focus();
		$("#supplier_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }
    if(business_name == ''){
		$("#business_name").focus();
		$("#business_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    }else if(business_id=='' && business_name!=''){
		$("#business_name").focus();
		$("#business_err").show().html('Please Select Registered Business Name');
		$('#busContainer').html('');
        allIsOk = false;      	
    }

    if(email == '' || !validateEmail(email)){
		$("#supplier_email").focus();
		$("#supplier_email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }else if(!check_emailexist(email)){
		$("#supplier_email").focus();
		$("#supplier_email_err").show().html('Email Address Already Exist');
        allIsOk = false;    	
    }

    if(contactno == ''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
  //   if(user_cat_id == ''){
		// $("#user_cat_id").focus();
		// $("#user_cat_id_err").show().html('Please Select Award Level');
  //       allIsOk = false;    	
  //   }

    if(password == ''){
		$("#password").focus();
		$("#p_err").show().html('Please add Password');
		$('.strongWeak').hide();
        allIsOk = false;    	
    }else if(!pvalid.success){
    	$("#password").focus();
    	$("#p_err").show().html(pvalid.msg);
    	allIsOk = false;  
    }

    if(cpassword == ''){
		$("#cpassword").focus();
		$("#cp_err").show().html('Please add Confirm Password');
        allIsOk = false;    	
    }else if(password !==cpassword){
		$("#cpassword").focus();
		$("#p_err").show().html("Password don't match");
        allIsOk = false;    	
    }


	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(timezone == ''){
		$("#timezone").focus();
		$("#timezone_err").show().html('Please Select Timezone');
        allIsOk = false;    	
    }

	if(business_id!=''){
		$.ajax({
			async: false,
			url: site_url+'supplier/check_supplier_already_added',
			type: "POST",
			data:{'business_id':business_id},
			dataType: "json",
			beforeSend:function(){
			},
			success: function(res) {
				if(!res.success){
					$("#business_name").focus();
					$("#business_err").show().html(res.msg);
					$('#busContainer').html('');
			        allIsOk = false; 
				}else{
					$("#business_err").hide().html('');
				}
			}
		});
	}

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_supplier')[0].reset();
					$('#supplier_country, #user_cat_id, #timezone').val(null).trigger('change');
					$('.imgInput, .hiddenfile').val('');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Supplier Added successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
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
    }
    return allIsOk    
});

$(document).on('submit','#edit_supplier',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#supplier_fname').val().trim();
	var lastname = $('#supplier_lname').val().trim();
	var country = $('#supplier_country :selected').val().trim();
	var email = $('#supplier_email').val();
	var contactno = $('#phone').val();
	var business_name = $('#sup_business').val();
	// var user_cat_id = $('#user_cat_id').val();
	var user_id = $('#user_id').val();
	var supplier_id = $('#supplier_id').val();

	$('.invalidText').hide();

	if (firstname == '') {
		$("#supplier_fname").focus();
		$("#supplier_fname_err").show().html('Please Enter First Name');
        allIsOk = false;
    } if(lastname == ''){
		$("#supplier_lname").focus();
		$("#supplier_lname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    } if(country == ''){
		$("#supplier_country").focus();
		$("#supplier_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    } 
    if(business_name == ''){
		$("#sup_business").focus();
		$("#business_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    }else if(business_id=='' && business_name!=''){
		$("#sup_business").focus();
		$("#business_err").show().html('Please Select Registered Business Name');
		$('#busContainer').html('');
        allIsOk = false;      	
    }

    if(email == '' || !validateEmail(email)){
		$("#supplier_email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }
    else if(!check_emailexist(email,user_id)){
		$("#supplier_email").focus();
		$("#email_err").show().html('Email Address Already Exist');
        allIsOk = false;    	
    }

    if(contactno == ''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
  //   if(user_cat_id == ''){
		// $("#user_cat_id").focus();
		// $("#user_cat_id_err").show().html('Please Select Award Level');
  //       allIsOk = false;    	
  //   }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			async: false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Supplier Updated successfully!').fadeOut('slow');
					$('.imgInput, .hiddenfile').val('');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
				}else{

					if(res.business_err){
						$("#business_name").focus();
						$("#business_err").show().html(res.msg);
						$('#busContainer').html('');						
					}else{			
						$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
						$('#successMsg').addClass('hide').removeClass('show');
						allIsOk = false;
					}
				}
				$('html, body').animate({
				    scrollTop: $(".dashBody").offset().top
				}, 1000);

			}
		});
    }
    return allIsOk    
});

$(document).on('keyup', '#sup_business', function(e) {
	$('#business_id').val('');
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'licensee/licensee_busList',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#busContainer').html(data.data);
					//$('#businessDiv').hide();
				}else{
					$('#busContainer').html('');
					//$('#businessDiv').show();
					$('#business_err').show().html("Business not registered");
				}
			}             
		});
		
	}else{ 
		$('#busContainer').html('');
	}
});

$(document).on('click', '.l_busItem', function() {
	var cat=$(this).html();
	var catVal=$(this).attr('data-val');
	var busname = $(this).html();
	$('#busContainer').html('');
	$('#business_id').val(catVal);
	$('#sup_business').val(busname);
});