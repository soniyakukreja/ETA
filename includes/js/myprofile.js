
$('body').on('click','#changePassbtn',function(){
  $('#changePassDiv').css('display','block');
  $(this).css('display','none');
}) ;

$('body').on('click','#cancelPassChange',function(){
  $('#changePassDiv').css('display','none');
  $('#changePassbtn').css('display','inline-block');
});

$(document).on('submit','#update_myPass',function (e) {
	e.preventDefault();
    var allIsOk = true;
    $('.invalidText,.strongWeak').css('display','none');

    var myOldPassword = document.getElementById('old_password').value;
    if(myOldPassword == ''){
        $('#old_p_err').html('Please enter your password').css('display','block'); 
        allIsOk = false;
    }

    var newPass = document.getElementById('password').value;
    if(newPass == ''){
        $('#p_err').html('Please enter new password').css('display','block');
        allIsOk = false;
    }else if(!validate_pass($('#password')[0])){
        allIsOk = false;
    }

    var conPass = document.getElementById('cpassword').value;
    if(conPass == ''){
        $('#cp_err').html('Please confirm your password').css('display','block');
        allIsOk = false;
    }

    if(newPass != conPass){
        $('#error_msg').html('Your passwords do not match').addClass('show').removeClass('hide');  
        allIsOk = false;
    }
  
    if( myOldPassword == '' &&  newPass == '' && conPass == ''){
        $('#error_msg').html('All fields Required').addClass('show').removeClass('hide');  
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
					
					$('.imgInput, .hiddenfile').val('');
					$('#error_msg').addClass('hide').removeClass('show');
					$('#success_msg').addClass('show').removeClass('hide').html(res.msg).fadeOut('slow');
					
					$('.strongWeak').hide();
					setTimeout( function(){ 
						$('#error_msg , #success_msg').addClass('hide').removeClass('show').fadeOut('slow');
					}  , 10000 );
					
				}else{
					$('#error_msg').addClass('show').removeClass('hide').html(res.msg);
					$('#success_msg').addClass('hide').removeClass('show');
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
