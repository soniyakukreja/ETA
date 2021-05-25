function validateEmail(email){
    var reg = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;		
	if (reg.test(email) == false) 
	{
		return false;
	}else{
	}
    return true;
}

$(document).on('submit','#addcompliance',function (e) {
	e.preventDefault();
    var allIsOk = true;
	var business = $("#business").val().trim();
	var business_id = $("#business_id").val();
	var l_country = $("#l_country :selected").val();
	var message = $("#message").val().trim();

	$('.invalidText').hide();

	if(business == ''){
		$("#business").focus();
		$("#business_err").show().html('Pleas select business');
		$("#busContainer").hide();
        allIsOk = false;
    }else if(business !='' && business_id==''){
		$("#business").focus();
		$("#business_err").show().html('Business is not registered with us');
		$("#busContainer").hide();
        allIsOk = false;
    }

    if(l_country=='' || l_country==0){
		$("#l_country").focus();
		$("#l_country_err").show();
        allIsOk = false;    	
    }

    if(message==''){
		$("#message").focus();
		$("#message_err").show();
        allIsOk = false;    	
    }

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
				if(res.businessErr){
					$("#business_err").show().html(res.msg);
				}else if(res.success==true) {
					$('#secondStep').hide();
					$('#thirdStep').show();
				}else{
					$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
					allIsOk = false;
				}
			}
		});
    }
    return allIsOk    
});


$(document).on('keyup', '#business', function(e) {
	$('#business_id').val('');
	e.preventDefault();
	var term=$(this).val();
	if(term!='' && term.length>=3){

		$.ajax({
			url: site_url+'complianeticket/busList',
			data: ({term: term}),
			dataType: 'json', 
			type: 'post',
			beforeSend:function(){

			},
			success: function(data) {
				if(data.status=='success'){
					$('#busContainer').html(data.data).show();
					$('#l_country').removeAttr('disabled');
				}else{
					$('#busContainer').html('');
				}
			}             
		});
		
	}else{ 
		$('#busContainer').html('');
	}
});

$('body').on('change', '#l_country', function() {
	$country = $('#l_country').val();
	if($country!="")
	{
		$('#message').removeAttr('disabled');
	}
});

$('body').on('click', '#reform', function() {
	window.location.reload();
});


$(document).on('click', '.l_busItem', function() {
	var cat=$(this).html();
	var catVal=$(this).attr('data-val');
	var busname = $(this).html();
	$('#busContainer').html('');
	$('#business_id').val(catVal);
	$('#business').val(busname);
	$("#business_err").hide();


	// var logosrc='';
	// $('#company_logo').src(logosrc);
	// $('#logoDiv').show();
});
