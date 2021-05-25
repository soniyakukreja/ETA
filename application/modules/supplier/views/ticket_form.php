<?php $this->load->view('include/header'); ?>

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
								<?php $this->load->view('consumer/leftbar'); ?>
									
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Add Ticket</h3>
										<div id="errorMsg" class="alert alert-danger hide"></div>
                                        <div id="successMsg" class="alert alert-success hide"></div>
											<?php echo form_open('',array('class'=>'addForm','id'=>'consumer_addticket','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Ticket Title</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_title" id="tic_title" class="form-control" placeholder="Ticket Title"  value="" type="text"></div>
														<span id="title_err" class="invalidText"></span>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="tic_cat_id" id="tic_cat_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['tic_cat_id']; ?>"><?php echo $value['tic_cat_name']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															</select>
														</div>
														<span id="cat_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
												<div class="form-group required">
													<label>Description</label>
													<div class="input-group">
														<span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i>
														</span>
														<textarea cols="5" rows="5" class="desript" name="tic_desc" id="tic_desc"></textarea>
													</div>
													<span id="content_err" class="invalidText"></span>
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
<script>

$(document).on('submit','#consumer_addticket',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('.invalidText').hide();
	
	var tic_title = $('#tic_title').val();
	var tic_cat_id = $('#tic_cat_id :selected').val().trim();
	var tic_desc = $('#tic_desc').val().trim();

    if(tic_title == ''){
		$("#tic_title").focus();
		$("#title_err").show().html('Please Add Ticket Title');
        allIsOk = false;    	
    }
    if(tic_cat_id == ''){
		$("#tic_cat_id").focus();
		$("#cat_err").show().html('Please Select Category');
        allIsOk = false;    	
    }

    if(tic_desc == ''){
		$("#tic_desc").focus();
		$("#content_err").show().html('Please Add Description');
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
					$('#consumer_addticket')[0].reset();
					$('#tic_cat_id').val(null).trigger('change');
					$('#tic_desc').val(null).trigger('change');

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
    }
    return allIsOk    
});
</script>