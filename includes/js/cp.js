$(document).on('submit','#add_contact',function (e) {
	e.preventDefault();

    var allIsOk = true;
	var business = false;

	var person = $('#person').val().trim();
	var business_id = $('#business_id').val().trim();
	var business_name = $('#cp_business').val().trim();
	var email = $('#email').val().trim();
	var phone = $('#phone').val().trim();	

	if(business_id!='' || business_name!=''){
		business = true;
	}
	
	$('.invalidText').hide();
	
	if(person == ''){
		$("#person").focus();
		$("#person_err").show().html('Please Enter Name');
        allIsOk = false;   
    }
    if(!business){
		$("#cp_business").focus();
		$("#business_err").show().html('Please Add Business');
        allIsOk = false;    	
    }else if($('#busContainer').length>0 && $('#busContainer').html().length>0){
		alert('Please select business');
		$("#cp_business").focus();
		allIsOk = false;           
    }

    if(business_id==''){
    	if($('#cp_business').attr('msg')=='makenew'){

			var address = $('#address').val().trim();
			var postcode = $('#postcode').val().trim();
			var suburb = $('#suburb').val().trim();
			var country = $('#country').val().trim();

			if(business_name == ''){
				$("#business_name").focus();
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
				$("#suburb_err").show().html('Please Add Suburb');
		        allIsOk = false;    
		    }
		    if(postcode == ''){
				$("#postcode").focus();
				$("#postcode_err").show().html('Please Add Postcode');
		        allIsOk = false;    
		    }
		    if(country == ''){
				$("#country").focus();
				$("#country_err").show().html('Please Select Country');
		        allIsOk = false;    
		    }
    	}else{
    		$("#business_err").show();
    		if($("#business_err").attr('msg')=='exist_under_cto'){ $("#business_err").html('Business Name is occupied'); }
    		allIsOk = false;
    	}		    
	}

    if(email ==''){
		$("#email").focus();
		$("#email_err").show().html('Please Add Email address');
        allIsOk = false;  
    }else if(email !=''){
        if(!validateEmail(email)){
			$("#email").focus();
			$("#email_err").show().html('Please Add Valid Email address');
	        allIsOk = false; 
        }
        else if(business_id!='' && check_contact_email(email,business_id)){
			$("#email").focus();
			$("#email_err").show().html('Email Address Already Exist');
	        allIsOk = false;       
	    }
    }

    if(phone ==''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Add Contact Number');
        allIsOk = false;  
    }	
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
		$.ajax({
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
					$('#add_contact')[0].reset();

					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Contact Person Added successfully!').fadeOut('slow');
					$('#businessDiv').hide();
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


$(document).on('keyup', '#person', function(e) {
	$('#cp_id,#cp_business_id').val('');
	//if($('#busContainer').length>0){ $('#busContainer').html(''); }
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			async: false,		
			url: site_url+'lead/contact/getCpList',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#cpContainer').html(data.data);
				}else{
					$('#cpContainer').html('');
				}
			}             
		});
		
	}else{
		$('#cpContainer').html('');
	}
});


$(document).on('click', '.cp_item', function() {
	var cpid=$(this).attr('data-val');
	var cp_email=$(this).attr('data-email');
	var cp_phone=$(this).attr('data-phone');
	var cp_business_id=$(this).attr('cp_business_id');

	var cpname = $(this).html();
	$('#cpContainer').html('');
	$('#cp_id').val(cpid);
	$('#person').val(cpname);

	$('#email').val(cp_email);
	$('#phone').val(cp_phone);
	$('#cp_business_id').val(cp_business_id);
	var cp_name = $(this).attr('cp_name');
	$('#cp_name').val(cp_name);

	var phone = document.querySelector("#phone");
	var iti = window.intlTelInput(phone, {
	  utilsScript: site_url+"includes/js/utils.js?1549804213570",
	  formatOnDisplay:false,	
	  initialCountry: "us",
	});
});

$(document).on('change','#email',function(){
	email = $(this).val();
	var business_id = $('#business_id').val();
	if(business_id!=''){
		return check_contact_email(email,business_id);
	}
});

function check_contact_email(email,business_id,contactid=''){
	console.log('contactid',contactid);
	allIsOk = true;
	url = site_url+'lead/contact/check_email_exist';
	$.ajax({
		async: false,
		url: url,
		type: "POST",
		data:{email:email,business_id:business_id,contactid:contactid},
		dataType: "json",
		beforeSend:function(){
			//ajaxindicatorstart();
		},
		success: function(res) {
			//ajaxindicatorstop();
			if(!res.success) {
				$('#email_err').show().html('Email Address Already Exist');
			}else{
				$('#email_err').hide();
				allIsOk = false;
			}
		}
	});
	return allIsOk;
}



$(document).on('keyup', '#cp_business', function(e) {
	$('#business_err').css('display','none');
	$('#business_id').val('');
	var cp_id = $('#cp_id').val();
	if($('#cp_business_id').length>0){ var bid = $('#cp_business_id').val(); }else{ bid =''; }
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			async: false,		
			url: site_url+'lead/contact/getBusinessList',
			//data: ({term: term,bid:bid,cp_id:cp_id}),
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#busContainer').html(data.data);
					$('#businessDiv').hide();
				}else{
					$('#cp_business').attr('msg',data.message);
					if(data.message=='duplicate'){
						$('#businessDiv').hide();
						$('#business_err').css('display','block').html('Contact Person already assigned to this business');
					}else
					if(data.message=='makenew'){
						$('#businessDiv').show();
						$('#email_err').html('');
					}else if(data.message=='exist_under_cto'){
						$('#businessDiv').hide();
						$('#business_err').css('display','block').html('Business Name is occupied');
					}
					$('#busContainer').html('');
				}
			}             
		});
		
	}else{
		$('#busContainer').html('');
	}
});



$(document).on('click', '.cp_bus_item', function() {
	
	allIsOk = true;
	var cp_business_id  = $('#cp_business_id').val();
	var catVal=$(this).attr('data-val');
	var busname = $(this).html();
	$('#cp_business').val(busname);
	$('#busContainer').html('');
	var email= $('#email').val();
	url = site_url+'lead/contact/check_email_exist';
	$('#business_id').val(catVal);

	if(email!=''){
		$.ajax({
			async:false,
			url: url,
			type: "POST",
			data:{email:email,business_id:catVal},
			dataType: "json",
			beforeSend:function(){
				//ajaxindicatorstart();
			},
			success: function(res) {
				//ajaxindicatorstop();
				if(!res.success) {
					$('#email_err').show().html('Email Address Already Exist');
					allIsOk = false;
				}else{
					$('#business_err').hide();
				}
			}
		});
		return allIsOk;
	}

});

$(document).on('submit','#edit_contact',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var person = $('#person').val().trim();
	var business_id = $('#business_id').val().trim();
	var business_name = $('#cp_business').val().trim();
	var email = $('#email').val().trim();
	var address = $('#address').val().trim();
	var postcode = $('#postcode').val().trim();
	var suburb = $('#suburb').val().trim();
	var country = $('#country').val().trim();
	var phone = $('#phone').val().trim();
	var contactid = $('#contactid').val();

	if(business_id!='' || business_name!=''){
		var business = true;
	}
	
	$('.invalidText').hide();
	
	if(person == ''){
		$("#person").focus();
		$("#person_err").show().html('Please Enter Name');
        allIsOk = false;    	
    }
    if(!business){
		$("#cp_business").focus();
		$("#business_err").show().html('Please Add Business');
        allIsOk = false;    	
    }
    if(business_id==''){

		if(business_name == ''){
			$("#business_name").focus();
			$("#business_err").show().html('Please Enter Business Name');
	        allIsOk = false;    	
	    }else if(address == ''){
			$("#address").focus();
			$("#address_err").show().html('Please Add Address');
	        allIsOk = false;    	
	    }else if(suburb == ''){
			$("#suburb").focus();
			$("#suburb_err").show().html('Please Add Suburb');
	        allIsOk = false;    	
	    }else if(postcode == ''){
			$("#postcode").focus();
			$("#postcode_err").show().html('Please Add postcode');
	        allIsOk = false;    	
	    }else if(country == ''){
			$("#country").focus();
			$("#country_err").show().html('Please Add Postcode');
	        allIsOk = false;    	
	    }
	
	}    
	if(email ==''){
		$("#email").focus();
		$("#email_err").show().html('Please Add Email address');
        allIsOk = false;  
        
    }else if(email !='' && !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Add Valid Email address');
        allIsOk = false;  
    }else if(business_id!='' && check_contact_email(email,business_id,contactid)){
		$("#email").focus();
		$("#email_err").show().html('Email Address Already Exist');
        allIsOk = false;       
    }

    if(phone ==''){
		$("#phone").focus();
		$("#phone_err").show().html('Please Add Contact Number');
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
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Contact Updated successfully!').fadeOut('slow');
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
