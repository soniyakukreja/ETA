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
										<h3>Edit Page Manager</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<?php 

										$urole= $this->generalmodel->getSingleRowById('user_role','urole_id', $pa['pb_role_id'], $returnType = 'array');  ?>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_page','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($pa['pb_featureimage'])){ echo base_url('uploads/page_feature_img/').$pa['pb_featureimage']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Feature Image</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-film"></i></span>
															<input  name="pb_featureimage" id="pb_featureimage" class="form-control" type="file"  accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
															<!-- <input type="hidden" name="pb_featureimage_h" id="pb_featureimage_h" class="hiddenfile" preview="true"> -->
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG</small>
														<br><span id="featureimage_err" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<input type="hidden" name="pb_id" value="<?php echo $pa['pb_id']; ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Page Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="pb_name" id="pb_name" value="<?php echo $pa['pb_name']; ?>" class="form-control" placeholder="Page Name" type="text">
														</div>
														<span id="name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Slug</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="pb_slug" id="pb_slug" class="form-control" placeholder="Slug" type="text" value="<?php echo $pa['pb_slug']; ?>"  minlength="1" maxlength="60">
														</div>
														<span id="slug_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Intended for</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<select class="form-control js-example-basic-single" name="pb_role_id" id="pb_role_id">
																<option value="">Please Select</option>
																 <?php $urole = $this->userdata['urole_id'];
															    if($urole == 1){?>
																<option value="1" <?php if($pa['pb_role_id']=="1"){ echo "selected";} ?>>ETA</option>
																<option value="2" <?php if($pa['pb_role_id']=="2"){ echo "selected";} ?>>Licensees</option>
															
																 <?php } 
															  	if($urole!=3){ ?>
															  
																<option value="3" <?php if($pa['pb_role_id']=="3"){ echo "selected";} ?>>Industry Associations</option>
															  <?php	}
															  ?>
																<option value="4" <?php if($pa['pb_role_id']=="4"){ echo "selected";} ?>>Consumers</option>
																<option value="5" <?php if($pa['pb_role_id']=="5"){ echo "selected";} ?>>Suppliers</option>
															</select>
														</div>
														<span id="role_id_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
															<select class="form-control js-example-basic-single" name="pb_status" id="pb_status">
																<option value="">Please Select</option>
																<option value="1" <?php if($pa['pb_status']=="1"){ echo "selected";} ?>>Published</option>
																<option value="0" <?php if($pa['pb_status']=="0"){ echo "selected";} ?>>Draft</option>
															</select>
														</div>
														<span id="status_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group ">
														<label>CTA Label</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="pb_cta_label" id="pb_cta_label" class="form-control" placeholder="CTA Label" type="text" value="<?php echo $pa['pb_cta_label']; ?>">
														</div>
														<span id="pb_cta_label_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group ">
														<label>CTA Link</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="pb_cta_text" id="pb_cta_text" class="form-control" placeholder="CTA Link" type="text" value="<?php echo $pa['pb_cta_text']; ?>">
														</div>
														<span id="pb_cta_text_err" class="invalidText"></span>
													</div>
												</div>

												<div class="col-md-6 col-md-offset-6">
													<div class="form-group">
														
															<input type="checkbox" name="pb_target" value="_blank" <?php if($pa['pb_target']=="_blank"){echo 'checked= checked';} ?>> Open link in new tab
														
															<span id="target_err" class="invalidText"></span>
															
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group  required">
 													<textarea  class="form-control xs ta-xt ckeditor" name="cta_desc" id="cta_desc" placeholder="Enter CTA Description *" ><?php echo $pa['pb_description']; ?></textarea>
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
<?php $this->load->view('include/crop_image_modal'); ?>
<?php $this->load->view('include/footer'); ?></div>
</body>
</html>