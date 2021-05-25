<script>

//=================contact======================//
/*
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
   //      else if(check_contact_email(email)){
			// $("#email").focus();
			// $("#email_err").show().html('Email Address Already Exist');
	  //       allIsOk = false;       
	  //   }
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


$(document).on('change','#email',function(){
	email = $(this).val();
	var business_id = $('#business_id').val();
	if(business_id!=''){
		return check_contact_email(email,business_id);
	}
});

function check_contact_email(email,business_id){
	allIsOk = true;
	url = site_url+'lead/contact/check_email_exist';
	$.ajax({
		url: url,
		type: "POST",
		data:{email:email,business_id:business_id},
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

	$.ajax({
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
				$('#business_err').show().html('Email Address Already Exist');
			}else{
				$('#business_err').hide();
				$('#business_id').val(catVal);
				allIsOk = false;
			}
		}
	});
	console.log('allIsOk',allIsOk);
	return allIsOk;
	// if(cp_business_id !='' && (cp_business_id==catVal)){
	// 	$('#business_err').css('display','block').html('Business Name is occupied');
	// }else{
	// 	$('#business_id').val(catVal);
	// }
});

$(document).on('submit','#edit_contact',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var person = $('#person').val().trim();
	var business_id = $('#business_id').val().trim();
	var business_name = $('#business').val().trim();
	var email = $('#email').val().trim();
	var address = $('#address').val().trim();
	var postcode = $('#postcode').val().trim();
	var suburb = $('#suburb').val().trim();
	var country = $('#country').val().trim();
	var phone = $('#phone').val().trim();

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
		$("#business").focus();
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
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Contact Updated successfully!').fadeOut('slow');
					
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
*/
//=================contact======================//

//=================business======================//

$(document).on('submit','#add_business',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var bus_name = $('#bus_name').val().trim();
	var address = $('#address').val().trim();
	var postcode = $('#postcode').val().trim();
	var suburb = $('#suburb').val().trim();
	var country = $('#country').val().trim();


	$('.invalidText').hide();
	
	if(bus_name == ''){
		$("#bus_name").focus();
		$("#bus_name_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    
    }else if(check_business_exist(bus_name)){
		$("#bus_name").focus();
		$("#bus_name_err").show().html('Business Name Already Exist');
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
		$("#country_err").show().html('Please Select Country');
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
					$('#add_business')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Business Added successfully!').fadeOut('slow');
				
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


$(document).on('submit','#edit_business',function (e) {
	e.preventDefault();
    var allIsOk = true;

	var bus_name = $('#bus_name').val().trim();
	var bus_id = $('#bus_name').attr('busid');
	var address = $('#address').val().trim();
	var postcode = $('#postcode').val().trim();
	var suburb = $('#suburb').val().trim();
	var country = $('#country').val().trim();

	$('.invalidText').hide();
	
	if(bus_name == ''){
		$("#bus_name").focus();
		$("#bus_name_err").show().html('Please Enter Business Name');
        allIsOk = false;    	
    }else if(check_business_exist(bus_name,bus_id)){
		$("#bus_name").focus();
		$("#bus_name_err").show().html('Business Name Already Exist');
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
		$("#country_err").show().html('Please Select Country');
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
				console.log(res);
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Business Updated successfully!').fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					  }  , 10000 );
					//window.location.reload();
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

$(document).on('change','#bus_name',function(){
	bus_name = $(this).val();
	bus_id = $(this).attr('busid');
	return check_business_exist(bus_name,bus_id);
});


function check_business_exist(bus_name,bus_id=''){

	allIsOk = true;
	url = site_url+'lead/business/check_business_exist';
	$.ajax({
		'async': false,
		url: url,
		type: "POST",
		data:{'bus_name':bus_name,'bus_id':bus_id},
		dataType: "json",
		beforeSend:function(){
			//ajaxindicatorstart();
		},
		success: function(res) {
			//ajaxindicatorstop();
			if(!res.success) {
				if($("#business_err").length){
					$('#business_err').show().html('Business Name Already Exist');
				}
				$('#bus_name_err').show().html('Business Name Already Exist');
			}else{

				if($("#business_err").length){
					$('#business_err').hide();
				}

				$('#bus_name_err').hide();
				allIsOk = false;
			}
		}
	});

	return allIsOk;
}


//=================business end ======================//

//=================deal start======================//

$(document).on('submit','#add_deal',function (e) {
	e.preventDefault();
    var allIsOk = true;
	var business = false;
	var deal_title = $('#deal_title').val().trim();
	//var cp_name = $('#cp_name').val().trim();
	var business_id = $('#business_id').val().trim();
	// var business_name = $('#bus_name').val().trim();
	var business_name = $('#deal_business').val().trim();
	var deal_value = $('#deal_value').val().trim();
	var stage = $('#stage :selected').val().trim();
	var close_date = $('#close_date').val().trim();
	var country = $('#country :selected').val().trim();
	var cp = $('#cp :selected').val().trim();
	var email = $('#email').val().trim();
	var phone = $('#phone').val().trim();		
	var newcontact = false;

	/*	
	if(business_id!='' || business_name!=''){
		business = true;
	}

	var contact_id = $('#contact_id').val().trim();
	if(contact_id==''){
		newcontact = true;
	}*/

	$('.invalidText').hide();
	
	if(deal_title == ''){
		$("#deal_title").focus();
		$("#deal_title_err").show().html('Please Enter Name');
        allIsOk = false;    	
    }

	if(business_name ==''){
		$("#bus_name").focus();
		$("#business_err").show().html('Please Add Business');
        allIsOk = false;    	
    }else if(business_id=='' && business_name !=''){
		$("#bus_name").focus();
		$("#business_err").show().html("Business don't exist OR Deal is Done with this business");
        allIsOk = false;   
    }
	if(cp == ''){
		$("#cp").focus();
		$("#cp_err").show().html('Please Select Contact Person');
        allIsOk = false;    	
    }
    /*
    if(cp_name ==""){
		$("#cp_name").focus();
		$("#cp_err").show().html('Please Select Contact Person');
        allIsOk = false;        	
    
    }else if(newcontact){
		if(email ==''){
			$("#email").focus();
			$("#email_err").show().html('Please Add Email address');
	        allIsOk = false;  
	    }else if(email !=''){
	        if(!validateEmail(email)){
				$("#email").focus();
				$("#email_err").show().html('Please Add Valid Email address');
		        allIsOk = false;  
	        }else if(check_contact_email(email)){
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
	    
	    if(business_name ==''){
			$("#bus_name").focus();
			$("#business_err").show().html('Please Add Business');
	        allIsOk = false;    	
	    }else 
	    if(business_name !='' && check_business_exist(business_name)){
				$("#bus_name").focus();
				$("#bus_name_err").show().html('Business Name Already Exist');
		        allIsOk = false;   
		}

		var address = $('#address').val().trim();
		var postcode = $('#postcode').val().trim();
		var suburb = $('#suburb').val().trim(); 

		if(business_name == ''){
			$("#bus_name").focus();
			$("#business_err").show().html('Please Enter Business Name');
	        allIsOk = false; 

	    }else if(business_name !='' && check_business_exist(business_name)){
			$("#bus_name").focus();
			$("#bus_name_err").show().html('Business Name Already Exist');
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
			$("#postcode_err").show().html('Please Add postcode');
	        allIsOk = false;    	
	    }
	    if(country == ''){
			$("#country").focus();
			$("#country_err").show().html('Please Select Country');
	        allIsOk = false;    	
	    }
	}
	*/


	if(deal_value ==""){
		$("#deal_value").focus();
		$("#dealval_err").show().html('Please Add Deal Value');
        allIsOk = false;        	
    }
    if(stage ==""){
		$("#stage").focus();
		$("#stage_err").show().html('Please Select Stage');
        allIsOk = false;        	
    }
    if(close_date ==""){
		//$("#close_date").focus();
		$("#closedate_err").show().html('Please Add Expected Close Date');
        allIsOk = false;        	
    }
    

	//var allIsOk = true;
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
				console.log(res);
				if(res.success) {
					$('#add_deal')[0].reset();
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Deal Added successfully!').fadeOut('slow');
				
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
						window.location.reload();

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

$(document).on('change','#deal_value, #close_date',function(){
	if($(this).val()!=''){ $(this).parents('.form-group').find('.invalidText').hide(); }
});

$(document).on('submit','#edit_deal',function (e) {
	e.preventDefault();
    var allIsOk = true;

    var deal_title = $('#deal_title').val().trim();
    var cp_name = $('#cp_name_editdeal').val().trim();
    var contact_id = $('#contact_id').val().trim();
	var deal_value = $('#deal_value').val().trim();
	var stage = $('#stage :selected').val().trim();


	// var business_id = $('#business_id').val().trim();
	// var business_name = $('#business').val().trim();
	// var email = $('#email').val().trim();
	// var address = $('#address').val().trim();
	// var postcode = $('#postcode').val().trim();
	// var suburb = $('#suburb').val().trim();
	// var country = $('#country').val().trim();

	// if(business_id!='' || business_name!=''){
	// 	var business = true;
	// }

	$('.invalidText').hide();
	
	if(deal_title == ''){
		$("#deal_title").focus();
		$("#deal_title_err").show().html('Please Enter Name');
        allIsOk = false;    	
    }
    if(cp_name ==""){
		$("#cp_name_editdeal").focus();
		$("#cp_err").show().html('Please Select Contact Person');
        allIsOk = false;        	
    }
    if(contact_id =='' && cp_name !=""){
		$("#cp_name_editdeal").focus();
		$("#cp_err").show().html("Contact person don't exist");
        allIsOk = false;        	    	
    }

    if(deal_value ==""){
		$("#deal_value").focus();
		$("#dealval_err").show().html('Please Add Deal Value');
        allIsOk = false;        	
    }
    if(stage ==""){
		$("#stage").focus();
		$("#stage_err").show().html('Please Select Stage');
        allIsOk = false;        	
    }

    /*
	if(person == ''){
		$("#person").focus();
		$("#person_err").show().html('Please Enter Name');
        allIsOk = false;    	
    }else 
    if(!business){
		$("#business").focus();
		$("#business_err").show().html('Please Add Business');
        allIsOk = false;    	
    }else if(email !='' && !validateEmail(email)){
		$("#email").focus();
		$("#email_err").show().html('Please Add valid email ID');
        allIsOk = false;   
    }else if(business_id==''){

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
	*/
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
				console.log(res);
				if(res.success) {
					
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html('Deal Updated successfully!').fadeOut('slow');
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

$(document).on('keyup', '#cp_name', function(e) {
	$('#business_id , #contact_id').val('');
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'lead/deal/getCP',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#cpContainer').html(data.data);
					
					$('#addbusinessDiv').hide();
				}else{
					$('#addbusinessDiv').show();
					$('#businessDivOne').hide();
					$('#cpContainer').html('');
				}
			}             
		});
		
	}else{
		$('#cpContainer').html('');
	}
});


$(document).on('keyup', '#cp_name_editdeal', function(e) {
	//$('#business_id , #contact_id').val('');
	e.preventDefault();
	var term=$(this).val();
	var business=$('#business_id').val();
	if(term!='' && term.length>=3){
	
		$.ajax({
			url: site_url+'lead/deal/getCP',
			data: ({term: term,'business':business}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#cpContainer').html(data.data);
					
					//$('#addbusinessDiv').hide();
					$('#cp_err').css('display','none');
				}else{
					//$('#addbusinessDiv').show();
					//$('#businessDivOne').hide();
					$('#cpContainer').html('');
					$('#cp_err').html("Contact Person don't exist").css('display','block');
				}
			}             
		});
		
	}else{
		$('#cpContainer').html('');
	}
});





$(document).on('click', '.cpItem', function() {
	$('#businessDivOne').show();
	var cat=$(this).html();
	var cpid=$(this).attr('cval');
	var bid=$(this).attr('bval');
	var bname=$(this).attr('bname');
	var cpname = $(this).html();
	$('#cpContainer').html('');
	$('#business_id').val(bid);
	$('#contact_id').val(cpid);
	$('#bus_name_poped').val(bname);
	

	if($('#cp_name_editdeal').length>0){
		$('#cp_name_editdeal').val(cpname);
	}

	if($('#cp_name').length>0){
		$('#cp_name').val(cpname);
		$('#business_id').val(bid);
	}

});
//=================deal end======================//


//=================deal======================//


/*
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
});*/

/*
$(document).on('focus', '#business', function(e) {
	if($('#cpContainer').length>0){ $('#cpContainer').html(''); }
});




$("#cp_business, #busContainer").mouseleave(function() {
    $('#busContainer').html('');
});

$(document).on('focusOut',"#cp_business", function(e) {
	console.log('',$("#busContainer").is(":focus"));
	if(!$("#busContainer").is(":focus")){
		$('#busContainer').html('');
	}
});*/

/*
$(document).on('keyup', '#person', function(e) {
	$('#cp_id,#cp_business_id').val('');
	//if($('#busContainer').length>0){ $('#busContainer').html(''); }
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
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
*/

$(document).on('keyup', '#deal_business', function(e) {
	$('#business_id').val('');
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'lead/deal/business_for_deal',
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
					$('#busContainer').html('');
					$('#businessDiv').show();
				}
			}             
		});
		
	}else{
		$('#busContainer').html('');
	}
});

$(document).on('click', '.deal_busItem', function() {
	var bid=$(this).attr('data-val');
	var name = $(this).html();

	$('#deal_business').val(name);
	$('#business_id').val(bid);
	$('#busContainer').html('');

	$.ajax({
		url: site_url+'lead/deal/contacts_of_business',
		data: ({bid: bid}),
		dataType: 'json', 
		type: 'post',
		beforeSend:function(){

		},
		success: function(res) {
			if(res.status=='success'){
				$('#cp').html(res.data);
			}
		}             
	});

});
 

</script>