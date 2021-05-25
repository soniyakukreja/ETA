<?php $this->load->view('include/header.php'); ?>

	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php $this->load->view('include/nav.php'); ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
								<?php $this->load->view('include/leftsidebar.php'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Update Document:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php //echo "<pre>"; print_r($detail); exit; ?>
										<?php echo form_open('',array('class'=>'addForm','id'=>'updateDoc','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Template Title</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input  name="temp_title" id="temp_title" class="form-control" placeholder="Template Title" type="text" readonly value="<?php echo $detail['temp_title']; ?>" >
														</div>
														<!-- <span id="ba_name_err" class="invalidText"></span> -->
													</div>
												</div>
											</div>	
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>User Type</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<select class="form-control js-example-basic-single" name="role_id" id="role_id">
															  <option value="">Please Select</option>
															  <option value="2" <?php if($detail['user_role']==2){ echo 'selected'; } ?>>Licensees</option>
															  <option value="3" <?php if($detail['user_role']==3){ echo 'selected'; } ?>>Industry Associations</option>
															</select>
														</div>
															<span id="role_err" class="invalidText"></span>
													</div>
												</div>
											</div>	
											<div class="row">		
												<div class="col-md-6">
													<div class="form-group">
														<label>Document</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input name="document" id="document" class="form-control" type="file" accept=".pdf, .doc, .docx">
														</div>
														<label>Only pdf ,doc,docx types are allowed</label>
														<span id="doc_err" class="invalidText"></span>
													</div>
												</div>
												
											</div>
											<div class="row">
												
												<div class="col-md-6">
													<?php /*
													<div class="form-group">
														<label>Link</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-film"></i></span>
															<input  name="ba_link" id="ba_link" class="form-control" type="text" placeholder="Link">
														</div>
															<span id="link_err" class="invalidText"></span>
													</div>
													*/ ?>
												</div>
											</div>

											<div class="row">
												<button type="submit">Submit</button>
											</div>
										<?php echo form_close(); ?>
									</div>
									<?php $this->load->view('include/rightsidebar.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>
<script type="text/javascript">
$(document).on('submit','#updateDoc',function(e){
	e.preventDefault();
	var allIsOk = true;

    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = new FormData(ds[0]);
		$.ajax({
			'async': false,
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
		    processData: false,
		    contentType: false,			
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res){
	            ajaxindicatorstop();
	            console.log(res);
	            if(res.success){
	                $('#updateDoc')[0].reset();
	                    
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
$('#updateDoc').disableAutoFill();
</script>