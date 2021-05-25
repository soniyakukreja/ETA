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
	<style type="text/css">
		.whistle {
		    width: 260px;
		    margin: auto;
		    margin-top: 50px;
		    background: #0a4672;
		    padding: 10px;
		    text-align: center;
		}
		.whistle a {
		    color: #fff;
		    font-size: 18px;
		    font-weight: 700;
		}
	</style>
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
								<p class="pb23">Sign in</p>
							</div>
							<?php echo form_open('checkuser',array('class'=>'loginFormIn','id'=>'login_form','autocomplete'=>'off')); ?>
								<div class="form-group">
									<label>Email ID</label>
									<input type="text" id="email" name="email" class="form-control" placeholder="Email ID" autocomplete="off">
									<span class="invalidText" id="email_err" style="display:none;">Invalid User</span>
								</div>
								<div class="forget">
									<a href="javascript:void(0)" class="forgotPassLink">Forgot password?</a>
								</div>
								<div class="btnLogin">
									<button type="submit">Next</button>
								</div>
							<?php echo form_close(); ?>
						</div>
						<div class="whistle"><a style="text-decoration:none;" href="<?php echo site_url('complianeticket'); ?>">Fill an Anonymous Breach of Compliance Form</a></div>

					</div>
				</section>

				<section class="jobDetail" id="secondStep" style="display:none;">
					<div class="loginForm">
						<div class="jobForm">
							<div class="loginLogo">
								<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
								<p>Welcome</p>
								<span id="useremail"></span>
							</div>
							<?php echo form_open('userlogin',array('class'=>'loginFormIn','id'=>'userlogin','autocomplete'=>'off')); ?>

								<input type="hidden" name="email" id="user_email" />
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
									<span class="invalidText" id="pass_err" style="display:none;">Incorrect Password</span>
								</div>
								<div class="forget">
									<a href="javascript:void(0)" class="forgotPassLink">Forgot password?</a>
								</div>
								<div class="btnLogin">
									<button type="submit">Next</button>
								</div>
							<?php echo form_close(); ?>
						</div>
						<?php /*<div class="whistle"><a href="<?php echo site_url('complianeticket'); ?>" >Fill an Anonymous Breach of Compliance Form</a></div>*/ ?>
					</div>
				</section>

				<section class="jobDetail" id="forgotSection" style="display:none;"> 
					<div class="loginForm">
						<div class="jobForm">
							<div class="loginLogo">
								<img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo">
								<p class="fgpassLabel">Find your email</p>
							</div>
							<div id="msgDiv" style="display:none;"></div>
							<?php echo form_open('forgot-password',array('class'=>'loginFormIn','id'=>'forgotForm','autocomplete'=>'off')); ?>
								<div class="form-group">
									<label>Enter your recovery email</label>
									<input type="text" id="femail" name="email" class="form-control" placeholder="Email ID" autocomplete="off" >
									<span class="invalidText" id="femail_err" style="display:none;">Invalid User</span>
								</div>
								<div class="forget">
									<a href="javascript:void(0)" id="backStepone">Back</a>
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
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('includes/js/jquery.disableAutoFill.min.js'); ?>"></script>

<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>';
	//$('#login_form ,#forgotForm').disableAutoFill();
	//$('#userlogin').disableAutoFill();
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/loaderjs.js');?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('includes/js/login.js'); ?>"></script>
</body>
</html>