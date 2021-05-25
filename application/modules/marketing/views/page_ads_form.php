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
								<?php $this->load->view('include/leftsidebar.php'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Add Banner</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_banner','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Banner Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input  name="ba_name" id="ba_name" class="form-control" placeholder="Banner Name" type="text">
														</div>
														<span id="ba_name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Banner Image</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="ba_image" id="ba_image" class="form-control" type="file" accept=".gif, .GIF, .jpeg, .jpg, .PNG, .png" is_valid="1">
															<!-- <input type="hidden" name="ba_image_h" id="ba_image_h"  class="hiddenfile"> -->
														<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG, GIF</small>
														<br><span id="ba_image_err" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Intended User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<select class="form-control js-example-basic-single" name="ba_roles_id" id="ba_roles_id">
															  <option value="">Please Select</option>
															  <?php $urole = $this->userdata['urole_id'];
															   if($urole == 1){?>
															  <option value="1">ETA</option>
															  <option value="2">Licensees</option>
															  <?php } 
															  	if($urole!=3){ ?>
															  <option value="3">Industry Associations</option>
															  <?php	}
															  ?>
															  <option value="4">Consumers</option>
															  <option value="5">Suppliers</option>
															</select>
														</div>
															<span id="ba_roles_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Link</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="fa fa-link" aria-hidden="true"></i></span>
															<input  name="ba_link" id="ba_link" class="form-control" type="text" placeholder="Link">
														</div>
															<span id="link_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
															<select class="form-control js-example-basic-single" name="ba_status" id="ba_status">
																<option value="">Please Select</option>
																<option value="1">Published</option>
																<option value="0">Draft</option>
															</select>
														</div>
															<span id="status_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Publish Date</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input  name="publish_date" id="publish_date" class="form-control dpic_dsbl_prev" type="text" placeholder="Publish Date">
														</div>
														<span id="date_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Banner Type</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
															<select class="form-control js-example-basic-single" name="ba_bannertype" id="ba_bannertype" onchange="changetype();">
																<option value="">Please Select</option>
																<option value="Top">Top</option>
																<option value="Right">Right</option>
															</select>
														</div>
															<span id="bannertype_err" class="invalidText"></span>
															<span id="imgsize" class="invalidText"></span>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group" style="margin-top: 30px;">
														<!-- <label>Open link in new tab</label> -->
														
															<input type="checkbox" name="target" value="_blank"> Open link in new tab
														
															<span id="target_err" class="invalidText"></span>
															
													</div>
												</div>
											</div>
											<div class="row">
												<button type="submit" style="margin-right: 17px;">Submit</button>
							
												<a href="javascript:window.history.go(-1);" class="addNew">Back</a>
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
<?php $this->load->view('include/crop_image_modal'); ?>
<?php $this->load->view('include/footer.php'); ?>
<script type="text/javascript">
	function changetype()
	{
		var type = $('#ba_bannertype').val();
		if(type == "Top")
		{
			$('#imgsize').show().html('Only 760*100 pixel');
		}else{
			$('#imgsize').show().html('Only 245*1212 pixel');

		}
	}
	
</script>
</div>
</body>
</html>