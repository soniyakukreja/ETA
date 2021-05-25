<?php $this->load->view('include/header'); ?>
<style>
	
</style>
	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
								<?php $this->load->view('include/leftsidebar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Update Template:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'update_mailtemplate','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-2">
													<label>Template Title:</label>
													
												</div>
												<div class="col-md-10">
													<h4><?php echo $detail['email_temp_title']; ?></h4>
												</div>
												<!-- <div class="col-md-6">
													<div class="form-group">
														<label>Template Title</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input  name="" id="temp_title" class="form-control" placeholder="Template Title" type="text" readonly value="<?php echo $detail['email_temp_title']; ?>" >
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>User Type</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<select class="form-control js-example-basic-single" name="role_id" id="role_id">
															  <option value="">Please Select</option>
															  <option value="2" <?php if($detail['user_role']==2){ echo 'selected'; } ?>>Licensees</option>
															  <option value="3" <?php if($detail['user_role']==3){ echo 'selected'; } ?>>Industry Associations</option>
															  <option value="3" <?php if($detail['user_role']==4){ echo 'selected'; } ?>>Consumer</option>
															  <option value="3" <?php if($detail['user_role']==5){ echo 'selected'; } ?>>Supplier</option>
															</select>
														</div>
														<span id="role_err" class="invalidText"></span>
													</div>
												</div> -->
											</div>
											<hr>
											<div class="row">
												<div class="col-md-1"><label>Tags:</label></div>
												<div class="col-md-11">
													<?php echo $detail['email_tags']; ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>Subject:</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input name="subject" id="subject" class="form-control" placeholder="Subject" type="text" value="<?php echo $detail['email_subject']; ?>" >
														</div>
														<span id="subject_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>Message Body</label>
														<div class="input-group">
															<textarea type="text" id="email_body" name="email_body" class="form-control ckeditor" placeholder="Email Content" ><?php echo $detail['email_body']; ?> </textarea>
														</div>
														<span id="text_err" class="invalidText"></span>
													</div>
												</div>
											</div>

											<div class="row">
												<button type="submit" style="margin-right: 17px;">Submit</button>
												<a href="javascript:window.history.go(-1);" class="addNew">Back</a>
											</div>
										<?php echo form_close(); ?>
									</div>
									<?php $this->load->view('include/rightsidebar'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
<?php $this->load->view('include/footer'); ?>
</div>
</body>
</html>
<script type="text/javascript">
$(document).on('submit','#update_mailtemplate',function(e){
	e.preventDefault();
	var allIsOk = true;
	$('.invalidText').css('display','none');

	var length = CKEDITOR.instances['email_body'].getData().replace(/<[^>]*>/gi, '').length;

	var email_body = CKEDITOR.instances['email_body'].getData();
	var subject = $('#subject').val();

	if(length==0){
		$('#text_err').css('display','block').html('Please Add Content');
		allIsOk = false;
	}

	if(subject==''){
		$('#subject_err').css('display','block').html('Please Add Subject');
		allIsOk = false;
	}

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $('#update_mailtemplate').serialize();
		$.ajax({
			url: url,
			type: "POST",
			data:{'email_body':email_body,'subject':subject},
    		dataType: "json",
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res){
	            ajaxindicatorstop();
	            console.log(res);
	            if(res.success){
	                $('#update_mailtemplate')[0].reset();
	                    
	                $('#errorMsg').addClass('hide').removeClass('show');
	                $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
	            
	                setTimeout( function(){ 
	                    $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
	                }  , 10000 );

	            }else{
	                $('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
	                $('#successMsg').addClass('hide').removeClass('show');

	            }
	            $('html, body').animate({
	                scrollTop: $(".dashBody").offset().top
	            }, 1000); 
	        }
		});
    }
});

$('#update_mailtemplate').disableAutoFill();
</script>