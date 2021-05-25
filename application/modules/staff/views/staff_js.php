<script>

$(document).on('change','#email',function(){
	email = $(this).val();
	return check_email_exist(email);
});

function check_email_exist(email){
	allIsOk = true;
	url = site_url+'staff/check_email_exist';
	$.ajax({
		'async': false,
		url: url,
		type: "POST",
		data:{email:email},
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


$(document).on('submit','#add_staff',function (e) {
	e.preventDefault();
    var allIsOk = true;
	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#country :selected').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	var dept = $('#dept :selected').val().trim();
	var assignee = $('#assign_to :selected').val().trim();
	var timezone = $('#timezone :selected').val().trim();
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
    if(dept == ''){
		$("#dept").focus();
		$("#dept_err").show().html('Please Select Department');
        allIsOk = false;    	
    }
    if(password == ''){
		$("#password").focus();
		$("#p_err").show().html('Please add Password');
		$(document).find('.strongWeak').hide();
        allIsOk = false;    	
    }else if(!pvalid.success){
    	$("#password").focus();
    	$("#p_err").show().html(pvalid.msg);
		//$(document).find('.strongWeak').hide();
    	allIsOk = false;  
    }
    if(cpassword == ''){
		$("#cpassword").focus();
		$("#cp_err").show().html('Please add Confirm Password');
        allIsOk = false;    	
    }
    // if(!validate_pass($('#cpassword'))){
    // 	$("#cpassword").focus();
    // 	$("#cp_err").show().html("Password don't match");
    // 	allIsOk = false;  
    // }
    else if(password !==cpassword){
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

    if(dept==4 && assignee==''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html("Please select assign to");
        allIsOk = false;       	
    }

    if(timezone==0 ||timezone==''){
		$("#timezone_to").focus();
		$("#timezone_err").show().html("Please select Timezone");
        allIsOk = false;       	
    }
    
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
					$('#add_staff')[0].reset();
					$('#pass_err, #cpassword_err').css('display','none');
					$('#country , #dept').val(null).trigger('change');
					$('.imgInput, .hiddenfile').val('');

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Staff Added successfully!').fadeOut('slow');
					$('.strongWeak').hide();
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


$(document).on('submit','#edit_staff',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#country :selected').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var dept = $('#dept :selected').val().trim();
	var assignee = $('#assign_to :selected').val().trim();
	var timezone = $('#timezone :selected').val().trim();

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
    if(dept == ''){
		$("#dept").focus();
		$("#dept_err").show().html('Please Select Department');
        allIsOk = false;    	
    }

    $( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(dept==4 && assignee==''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html("Please select assign to");
        allIsOk = false;       	
    }

    $( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(timezone==0 ||timezone==''){
		$("#timezone_to").focus();
		$("#timezone_err").show().html("Please select Timezone");
        allIsOk = false;       	
    }
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
					
					$('.imgInput, .hiddenfile').val('');
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Staff Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
						//window.location.reload();
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

$(document).on('change','#dept',function(){
	if($(this).val()==4){
		$('#assignDiv').show();
	}else{
		$('#assignDiv').hide();
	}
});

</script>