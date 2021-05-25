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
										<h3>Add Page</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_page','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Page Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<input  name="pb_name" id="pb_name" class="form-control" placeholder="Page Name" type="text">
														</div>
														<span id="name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group  required">
														<label>Slug</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="pb_slug" id="pb_slug" class="form-control" placeholder="Slug" type="text" minlength="1" maxlength="60">
														</div>
														<span id="slug_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group  required">
														<label>Intended for</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<select class="form-control js-example-basic-single" name="pb_role_id" id="pb_role_id">
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
														<span id="role_id_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group  required">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
															<select class="form-control js-example-basic-single" name="pb_status" id="pb_status">
																<option value="">Please Select</option>
																<option value="1">Published</option>
																<option value="0">Draft</option>
															</select>
														</div>
														<span id="status_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>CTA Label</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="pb_cta_label" id="pb_cta_label" class="form-control" placeholder="CTA Label" type="text">
														</div>
														<span id="pb_cta_label_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>CTA Link</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="fa fa-link" aria-hidden="true"></i></span>
															<input  name="pb_cta_text" id="pb_cta_text" class="form-control" placeholder="CTA Link" type="text">
														</div>
														<span id="pb_cta_text_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group  required">
														<label>Feature Image</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-film"></i></span>
															<input  name="pb_featureimage" id="pb_featureimage" class="form-control" type="file"  accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
															<!-- <input type="hidden" name="pb_featureimage_h" id="pb_featureimage_h" class="hiddenfile"> -->
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG</small>
														<br><span id="featureimage_err" class="invalidText image_err"></span>
													</div>
												</div>
										
												<div class="col-md-6">
													<div class="form-group" style="margin-top: 30px;">
														<!-- <label>Open link in new tab</label> -->
														
															<input type="checkbox" name="pb_target"> Open link in new tab
														
															<span id="target_err" class="invalidText"></span>
															
													</div>
												</div>
												
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group  required">
													<label>Content</label>
 													<textarea  class="form-control xs ta-xt ckeditor" name="cta_desc" id="cta_desc" placeholder="Enter CTA Description *" ></textarea>
													<span id="content_err" class="invalidText"></span>
													</div>
													
												</div>
											</div>
											
											<div class="row">
												<button type="submit" style="margin-right: 17px;" class="addNew">Submit</button>
							
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
<?php $this->load->view('include/footer.php'); ?></div>
</body>
</html>