
$(document).on('change','#email',function(){
	email = $(this).val();
	return check_email_exist(email);
});

function check_email_exist(email,id=''){
	allIsOk = true;
	url = site_url+'consumer/check_email_exist';
	$.ajax({
		'async': false,
		url: url,
		type: "POST",
		data:{'email':email,'id':id},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(res) {
			if(!res.success) {
				$('#email_err').show().html('Email Address Already Exist!');
				//$('#email').focus();
			}else{
				$('#email_err').hide();
				allIsOk = false;
			}
		}
	});

	return allIsOk;
}


$(document).on('submit','#add_consumer',function (e) {
	e.preventDefault();

    var allIsOk = true;
    
	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#country :selected').val().trim();
	var assign_to = $('#assign_to :selected').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
    var business_id = $('#business_id').val();
	var businesname = $('#con_business').val();
	var pvalid = validate_pass($('#password'));


	$('.invalidText').hide();
	if(firstname == ''){
		$("#firstname").focus();
		$("#firstname_err").show().html('Please Enter First Name');
        allIsOk = false;    	
    }
    if(lastname == ''){
		$("#lastname").focus();
		$("#lastname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }
    if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }else if(check_email_exist(email)){
		$("#email").focus();
		$("#email_err").show().html('Email Address Already Exist');
        allIsOk = false;    	
    }
    else if(contactno!='' && !validateMobile(contactno)){
    	$("#phone").focus();
		$("#contactno_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
    if(country == ''){
		$("#country").focus();
		$("#country_err").show().html('Please Select Country');
        allIsOk = false;    	
    } 
    if(assign_to == ''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html('Please Assign consumer to KAM');
        allIsOk = false;    	
    }

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

    if(business_id=='' && businesname ==''){
		$("#cpassword").focus();
		$("#business_err").show().html("Please select Business");
        allIsOk = false;       	
    }else if(business_id=='' && businesname !=''){
		$("#cpassword").focus();
		$("#business_err").show().html("Business not registered");
        allIsOk = false;
    }else if(business_id!='' && businesname !='' && !check_already(business_id)){
		$("#cpassword").focus();
		$("#business_err").show().html("Business is already assigned");
        allIsOk = false;
    }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#add_consumer')[0].reset();
					$('#pass_err, #cpassword_err').css('display','none');
					$('.imgInput, .hiddenfile').val('');
					$('#country').val(null).trigger('change');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Consumer Added successfully!').fadeOut('slow');
					
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					 }  , 3000 );						
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


$(document).on('submit','#edit_consumer',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#country :selected').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var id = $('#id').val();
	var assign_to = $('#assign_to :selected').val().trim();

	var password = $('#password').val();
	var cpassword = $('#cpassword').val();	
	var pvalid = validate_pass($('#password'));
	var cpvalid = validate_pass($('#cpassword'));
    var business_id = $('#business_id').val();
	var businesname = $('#con_business').val();

	$('.invalidText,.strongWeak').hide();
	
	if(firstname == ''){
		$("#firstname").focus();
		$("#firstname_err").show().html('Please Enter First Name');
        allIsOk = false;    	
    }
    if(lastname == ''){
		$("#lastname").focus();
		$("#lastname_err").show().html('Please Enter Last Name');
        allIsOk = false;    	
    }
    if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }else if(check_email_exist(email,id)){
		$("#email").focus();
		$("#email_err").show().html('Email Address Already Exist');
        allIsOk = false;    	
    }

    if(assign_to == ''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html('Please Assign consumer to KAM');
        allIsOk = false;    	
    }
    
    if(contactno!='' && !validateMobile(contactno)){
		$("#phone").focus();
		$("#contactno_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
    if(country == ''){
		$("#country").focus();
		$("#country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }

    if(password !='' && !pvalid.success){
    	$("#password").focus();
    	$("#p_err").show().html(pvalid.msg);
    	//$('.strongWeak').hide();
    	allIsOk = false;  
    }
	
	if(cpassword !='' && !cpvalid.success){
    	$("#cpassword").focus();
    	$("#cp_err").show().html(cpvalid.msg);
    	allIsOk = false;  
    }else if(password !='' && password !==cpassword){
		$("#cpassword").focus();
		$("#p_err").show().html("Password don't match");
        allIsOk = false;    	
    }


    if(business_id=='' && businesname ==''){
		$("#cpassword").focus();
		$("#business_err").show().html("Please select Business");
        allIsOk = false;       	
    }else if(business_id=='' && businesname !=''){
		$("#cpassword").focus();
		$("#business_err").show().html("Business not registered");
        allIsOk = false;
    }else if(business_id!='' && businesname !='' && !check_already(business_id,id)){
		$("#cpassword").focus();
		$("#business_err").show().html("Business is already assigned");
        allIsOk = false;
    }

	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});    

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
		$.ajax({
			async: false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('.strongWeak').hide();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html(res.msg);
					$('.imgInput, .hiddenfile').val('');
					
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


$(document).on('keyup', '#con_business', function(e) {
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
	var b_id=$(this).attr('data-val');
	$('#business_id').val(b_id);
	if($(document).find('#id').length>0){
		var consuemrid=$(document).find('#id').val();
	}else{
		var consuemrid='';
	} 
	var busname = $(this).html();
	$('#con_business').val(busname);
	$('#busContainer').html('');
	already_return = check_already(b_id,consuemrid);
});

function check_already(b_id,consuemrid=''){
	var allIsOk = true;
	$.ajax({
		async:false,
		url: site_url+'consumer/check_business_already',
		data: ({b_id: b_id,consuemrid:consuemrid}),
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){
		},
		success: function(data) {
			if(data.success){
				$('#business_err').show().html("Business is already assigned");
				allIsOk = false;
			}else{
				$('#business_err').hide();
			}
		}             
	});	
	return allIsOk;
}