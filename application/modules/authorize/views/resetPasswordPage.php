<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ethical</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>

<div id="wrapper">
	<article>
		<div id="contents">
			<div id="main">
				<section class="jobDetail" id="firstStep"> 
					<div class="loginForm">
						<div class="jobForm">
							<div class="loginLogo">
								<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
								<p class="pb23">Let's reset your password!</p>
							</div>
							<?php echo form_open('resetPasswordForm',array('class'=>'loginFormIn','id'=>'resetpass_form')); ?>

								<input type="hidden" name="userId" value="<?php echo $this->uri->segment(2); ?>">
								<input type="hidden" name="token" value="<?php echo $this->uri->segment(3); ?>">

								<div class="form-group">
									<label>Password</label>
									<span

title="Minimum 8 characters in length
Contains 3/4 of the following items:
- Uppercase Letters
- Lowercase Letters
- Numbers
- Symbols"									></span>
									<input type="password" name="pass" id="pass" class="form-control" placeholder="New Password" onkeyup="return validate_pass(this)">
									<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
									<span class="invalidText" id="pass_err" style="display:none;">Please Enter Your Password</span>
									
									<div class="strongWeak" id="password_err" style="display:none;">
										<div class="w3-border">
											<div class="stren_line" style="height:5px;width:20%;background: red;"></div>
										</div>
										<span class="stren_text">Weak</span>
									</div>								
								</div>

								<div class="form-group">
									<label>Confirm Password</label>
									<input id="cpass" type="password" class="form-control" name="cpass" placeholder="Confirm Password*" onkeyup="return validate_pass(this)" >
									<span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
									<span class="invalidText" id="cpass_err" style="display:none;">Please Confirm Your Password</span>
								</div>
								
								<div class="btnLogin">
									<button type="submit">Submit</button>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</section>
			</div><!-- /#main -->
		</div><!-- /#contents -->
	</article>	
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/loaderjs.js');?>"></script>

<script>

$(".toggle-password").click(function() {
	$(this).toggleClass("fa-eye fa-eye-slash");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
		input.attr("type", "text");
	} 
	else {
		 input.attr("type", "password");
	}
});


function validate_pass(ds){
	var dsval = $(ds).val();
	var stre_field = $(ds).parents('.form-group').find('.strongWeak');
	var err_field = $(ds).parents('.form-group').find('.invalidText');

	if(dsval!='' ){ stre_field.show(); err_field.hide(); }
	var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/gi;
    var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;

	var percent = 0;
	//====check length
	if(dsval.length >=8){
		percent +=20;
	}
	
	//====check uppercase
	if(dsval.replace(/[^A-Z]/g, "").length>=1){
		percent +=20;
	}
	//====check lowercase
	if(dsval.replace(/[^a-z]/g, "").length>=1){
		percent +=20;
	}

	//====check numbers
	if(dsval.replace(/[^0-9]/g, "").length>=1){
		percent +=20;
	}
	//====check special charachter
	if(dsval.match(specialChars)){
		percent +=20;
	}

	if(parseInt(percent)<=25){
		if(parseInt(percent)==0){
			stre_field.find('.stren_line').css({"background": "red","width":"10%"});
		}else{
			stre_field.find('.stren_line').css({"background": "red","width":percent+"%"});
		}
		stre_field.find('.stren_text').html('Very Weak');
		return { success : false, msg : 'Your Password is Weak' };

	}

	if(parseInt(percent)>25 && parseInt(percent)<50){
		stre_field.find('.stren_line').css({"background": "red","width":percent+"%"});
		stre_field.find('.stren_text').html('Weak');
		return { success : false, msg : 'Your Password is Weak' };

	}

	if(parseInt(percent)>50 && parseInt(percent)<100){
		stre_field.find('.stren_line').css({"background": "#8de6498c","width":percent+"%"});
		stre_field.find('.stren_text').html('Medium');
		return { success : false, msg : 'Your Password is Medium' };

	}

	if(parseInt(percent)==100 && regex.test(dsval)){
		stre_field.find('.stren_line').css({"background": "#49e663","width":percent+"%"});
		stre_field.find('.stren_text').html('Strong');

		var pass = $('#pass').val().trim();
		var cpass = $('#cpass').val().trim();

		if(pass !='' && cpass !=''){
			if(pass != cpass) {
			    return { success : false, msg : "Your Password doesn't match" };
			} else {
			    $('#pass_err ,#cpass_err').hide();
			    return { success : true };
			}
		}else{
			return { success : true };
		}	
	}
}


$(document).on('submit','#resetpass_form',function (e) {

	e.preventDefault();
	$('.invalidText').hide();

    var allIsOk = true;
	var pass_msg = $("#pass").val();
	var repass_msg = $("#cpass").val();

	var pvalid = validate_pass($('#pass'));
	var cpvalid = validate_pass($('#cpass'));	

	//Check if empty or not
	if (pass_msg == '') {
		$("#pass_err").show();
		allIsOk = false;
    }else if(!pvalid.success){
    	$("#pass").focus();
    	$("#pass_err").show().html(pvalid.msg);
    	allIsOk = false;  
    }else if(repass_msg !='' && !cpvalid.success){
    	$("#cpass").focus();
    	$("#cpass_err").show().html(cpvalid.msg);
    	allIsOk = false;  
    }
	
	if (repass_msg == '') { 
		$("#cpass_err").show().html('Please Confirm Your Password');
        allIsOk = false;
    }

    if(pass_msg!='' && repass_msg!='' && pass_msg != repass_msg){
       $('#cpass_err').css('display','block');
       $('#cpass_err').html("Your Password doesn't match");   
       allIsOk = false;
    }
    // if(grecaptcha.getResponse() == '') {
    // 	$("#error_captcha").show();
    // 	allIsOk = false;
    // }else{
    // 	$("#error_captcha").hide();    
    // }

	if(allIsOk == true){
		var url = $(this).attr('action');
		  $.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: $("#resetpass_form").serialize(),
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if (res.success == true)
				{
					window.location.href = res.link ;
				}else{
		            $('body').find('#cpass_err').show();
		            $('body').find('#cpass_err').html(res.msg);
				}
			}
		});
	}

	return allIsOk;
});

</script>
</body>
</html>