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
				<section class="jobDetail" id="secondStep">
					<div class="loginForm">
						<div class="jobForm">
							<div class="loginLogo">
								<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
								<p>Anonymous Breach of Compliance Form</p>
								
							</div>
							<div id="errorMsg" class="alert alert-danger hide"></div>
                            <div id="successMsg" class="alert alert-success hide"></div>
							<?php echo form_open('complianeticket/addcompliance',array('class'=>'loginFormIn','id'=>'addcompliance','autocomplete'=>'off')); ?>

								<input type="hidden" name="email" id="user_email" />
								<div class="form-group required">
									
									<div class="form-group">
										<label>Company Name</label>
										<input name="business_name" id="business" class="form-control" placeholder="Which company is this in regards to?" autocomplete="off" value="" type="text">
										<input type="hidden" name="business_id" id="business_id">
									
										<div style="position:relative;">
											<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="busContainer">
											</ul>
										</div>														
										<span id="business_err" class="invalidText" style="display:none;">Please enter company name</span>
									</div>

									<div class="form-group" style="display: none;" id="logoDiv">
										<div class="loginLogo">
											<img id="company_logo" src="<?php echo base_url('uploads/'); ?>" alt="Logo">
										</div>
									</div>
								<div class="form-group required">
									<label>Country</label>
									<div class="dateInput">
										<select class="form-control js-example" name="l_country" id="l_country"  autocomplete="off">
										  <option value="">Which country are they located in?</option>
										  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
											<option value="<?php echo $value['id']; ?>"><?php echo $value['country_name']; ?></option>
										  <?php } } ?>
										</select>
									</div>
									<span id="l_country_err" class="invalidText" style="display:none;">Please select country</span>
								</div>
								<div class="form-group">
									<label>Message</label>
									<div class="form-group">
										<textarea cols="5" rows="5" class="form-control" name="message" id="message" placeholder="Please enter your message" disabled></textarea>
									</div>
									<span class="invalidText" id="message_err" style="display:none;">Please enter your message</span>
								</div>
								
								<div class="btnLogin">
									<button type="submit">Submit</button>
								</div>
							<?php echo form_close(); ?>
								<div class="forget">
									<a href="<?php echo site_url(); ?>" id="backStepone">Go Back to Login</a>
								</div>
						</div>
					</div>
				</section>

				<section class="jobDetail" id="thirdStep" style="display:none;"> 
					<div class="loginForm">
						<div class="jobForm">
							<div class="loginLogo">
								<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
								<p class="fgpassLabel">Anonymous Breach of Compliance Form</p>
							</div>
							<div id="msgDiv" style="text-align:center">your report has been submitted to ETA Global!</div>
							
								
							<div class="btnLogin">
								<button type="button" id="reform">Submit Another</button>
							</div>
						</div>
					</div>
				</section>
			</div><!-- /#main -->
		</div><!-- /#contents -->
	</article>	
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>';
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/loaderjs.js');?>"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/compliancelogin.js'); ?>"></script>
</body>
</html>