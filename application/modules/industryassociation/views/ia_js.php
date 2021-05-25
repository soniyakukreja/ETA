<script>


$(document).on('change','#email',function(){
	email = $(this).val();
	return check_email_exist(email);
});

function check_email_exist(email){
	allIsOk = true;
	url = site_url+'industryassociation/check_email_exist';
	$.ajax({
		'async': false,
		url: url,
		type: "POST",
		data:{email:email},
		dataType: "json",
		beforeSend:function(){
			//ajaxindicatorstart();
		},
		success: function(res) {
			//ajaxindicatorstop();
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

$(document).on('click','.sentInterest',function (e) {

	ds = $(this);
	var url = $(this).attr('action');
	$.ajax({
		url: url,
		dataType: "json",
		beforeSend:function(){
			ajaxindicatorstart();
		},
		success: function(res) {
			ajaxindicatorstop();
			if(res.success) {
				$('#errorMsg').addClass('hide').removeClass('show');
				$('#successMsg').addClass('show').removeClass('hide').html(res.msg);

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
});

//================IA start===============//
$(document).on('submit','#add_ia',function (e) {
	e.preventDefault();

    var allIsOk = true;
	var lic_number = $('#lic_number').val();
	var lic_startdate = $('#lic_startdate').val().trim();
	var lic_enddate = $('#lic_enddate').val().trim();
	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var ia_country = $('#ia_country :selected').val().trim();
	//var dept = $('#dept').val().trim();
	var email = $('#email').val().trim();
	var contactno = $('#phone').val();
	var business_name = $('input[name="business_name"]').val().trim();
	var business_id = $('#business_id').val().trim();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	var assign_to = $('#assign_to :selected').val().trim();

	var pvalid = validate_pass($('#password'));
	var cpvalid = validate_pass($('#cpassword'));

	$('.invalidText, .strongWeak').hide();

	if(business_id!='' || business_name!=''){
		var business = true;
	}
	
	if (lic_number == '') {
		$("#lic_number").focus();
		$("#lic_number_err").show().html('Please Enter License Number');
        allIsOk = false;
    }
    if(lic_startdate == ''){
		//$("#lic_startdate").focus();
		$("#lic_startdate_err").show().html('Please Enter License Start Date');
        allIsOk = false;    	
    }
    if(lic_enddate == ''){
		//$("#lic_enddate").focus();
		$("#lic_enddate_err").show().html('Please Enter License End Date');
        allIsOk = false;    	
    }
    if(assign_to == ''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html('Please Select Kam');
        allIsOk = false;    	
    }      
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
    if(contactno == ''|| !validateMobile(contactno)){
		$("#phone").focus();
		$("#contactno_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
    if(ia_country == ''){
		$("#ia_country").focus();
		$("#ia_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }
  //   if(dept == ''){
		// $("#dept").focus();
		// $("#dept_err").show().html('Please Select Department');
  //       allIsOk = false;    	
  //   }
    if(password == ''){
		$("#password").focus();
		$("#p_err").show().html('Please add Password');
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
    }else if(!cpvalid.success){
    	$("#cpassword").focus();
    	$("#cp_err").show().html(cpvalid.msg);
    	allIsOk = false;  
    }
    if(password!='' && cpassword!='' && password !==cpassword){
		$("#cpassword").focus();
		$("#cp_err").hide()
		$("#p_err").show().html("Password don't match");
        allIsOk = false;    	
    }

 
	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

    if(!business){
		$('input[name="business_name"]').focus();
		$("#business_err").show().html('Please Add Business Name');
        allIsOk = false;    	
    }else if(business_id==''){
    	
    	var address = $('#address').val().trim();
		var postcode = $('#postcode').val().trim();
		var suburb = $('#suburb').val().trim();
		var country = $('#country').val().trim();
		var state = $('#state').val().trim();

		if(business_name == ''){
			$('input[name="business_name"]').focus();
			$("#business_err").show().html('Please Enter Business Name');
	        allIsOk = false;    	
	    }
	    if(address == ''){
			$("#address").focus();
			$("#address_err").show().html('Please Add Address');
	        allIsOk = false;    	
	    }
	    if(suburb == ''){
			$("#suburb").focus();
			$("#suburb_err").show().html('Please Add Suburb/Provision');
	        allIsOk = false;    	
	    }
	    if(postcode == ''){
			$("#postcode").focus();
			$("#postcode_err").show().html('Please Add postcode');
	        allIsOk = false;    	
	    }
	    if(country == ''){
			$("#country").focus();
			$("#country_err").show().html('Please Add Country');
	        allIsOk = false;    	
	    }
	    if(state == ''){
			$("#state").focus();
			$("#state_err").show().html('Please Enter State');
	        allIsOk = false;    	
	    }
	}

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
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
					$('#add_ia')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('#'+res.resource_id+' Added successfully!').fadeOut('slow');
					
					$('#ia_country, #country, #category').val(null).trigger('change');
					$('.imgInput, .hiddenfile').val('');

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

$(document).on('keyup', '#ia_business', function(e) {
	$('#business_id').val('');
	e.preventDefault();
	var term=$(this).val();
	
	if($('#iaid').length >0){
		var id = $('#iaid').val();
	}else{
		var id = '';
	}

	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'industryassociation/industryassociation/busList',
			data: ({term: term,id:id}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#busContainer').html(data.data);
					$('#businessStDiv').hide();
					$('#businessDiv').hide();
				}else{
					$('#busContainer').html('');
					$('#businessDiv').show();
					$('#businessStDiv').show();
				}
			}             
		});
		
	}else{
		$('#busContainer').html('');
	}
});


$(document).on('click', '.ia_busItem', function() {
	var cat=$(this).html();
	var catVal=$(this).attr('data-val');
	var busname = $(this).html();
	$('#busContainer').html('');
	$('#business_id').val(catVal);
	$('#ia_business').val(busname);
});

//========================================//


$(document).on('submit','#edit_ia',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var lic_number = $('#lic_number').val();
	var lic_startdate = $('#lic_startdate').val().trim();
	var lic_enddate = $('#lic_enddate').val().trim();
	var firstname = $('#firstname').val().trim();
	var lastname = $('#lastname').val().trim();
	var country = $('#ia_country :selected').val().trim();
	//var dept = $('#dept').val().trim();
	var email = $('#email').val();
	var contactno = $('#phone').val();
	var assign_to = $('#assign_to :selected').val().trim();

	$('.invalidText, .strongWeak').hide();

	if(lic_number == '') {
		$("#lic_number").focus();
		$("#lic_number_err").show().html('Please Enter License Number');
        allIsOk = false;
    }
	if(lic_startdate == ''){
		//$("#lic_startdate").focus();
		$("#lic_startdate_err").show().html('Please Enter License Start Date');
        allIsOk = false;    	
    }
    if(lic_enddate == ''){
		//$("#lic_enddate").focus();
		$("#lic_enddate_err").show().html('Please Enter License End Date');
        allIsOk = false;    	
    }   
    if(assign_to == ''){
		$("#assign_to").focus();
		$("#assign_to_err").show().html('Please Select Kam');
        allIsOk = false;    	
    }  
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

  //   if(dept == ''){
		// $("#dept").focus();
		// $("#dept_err").show().html('Please Select Department');
  //       allIsOk = false;    	
  //   }
    if(country == ''){
		$("#ia_country").focus();
		$("#ia_country_err").show().html('Please Select Country');
        allIsOk = false;    	
    }
    if(email == '' || !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Enter Email Address');
        allIsOk = false;    	
    }
    if(contactno == ''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Enter Contact Number');
        allIsOk = false;    	
    }
 
	$( ".imgInput" ).each(function(i,v) {
	  if($(this).attr('is_valid')==0){
	  	$(this).parents('.form-group').find('.image_err').css('display','block');
	  	allIsOk = false;  
	  }
	});

	var address = $('#address').val().trim();
	var postcode = $('#postcode').val().trim();
	var suburb = $('#suburb').val().trim();
	var country = $('#country').val().trim();
	var state = $('#state').val().trim();

	if(address == ''){
		$("#address").focus();
		$("#address_err").show().html('Please Add Address');
        allIsOk = false;    	
    }
    if(suburb == ''){
		$("#suburb").focus();
		$("#suburb_err").show().html('Please Add Suburb/Provision');
        allIsOk = false;    	
    }
    if(postcode == ''){
		$("#postcode").focus();
		$("#postcode_err").show().html('Please Add postcode');
        allIsOk = false;    	
    }
    if(country == ''){
		$("#country").focus();
		$("#country_err").show().html('Please Add Country');
        allIsOk = false;    	
    }
    if(state == ''){
		$("#state").focus();
		$("#state_err").show().html('Please Enter State');
        allIsOk = false;    	
    }

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
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
					$('#successMsg').addClass('show').removeClass('hide').html('Industry Association Updated successfully!').fadeOut('slow');
					$('.imgInput, .hiddenfile').val('');
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



</script>