<?php $this->load->view('include/header');
$userdata = $this->session->userdata('userdata');
$userrole = $userdata['urole_id'];
 ?>

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
										<h3>Edit Banner</h3>
<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_banner','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											
											<div class="row">
												<div class="col-md-12">
													<img src="<?php if(!empty($ba['ba_image'])){ echo base_url('uploads/banner/').$ba['ba_image']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" id="imgPreview">
												</div>
											</div>
											<br><div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Banner Image</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="ba_image" id="ba_image" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png,.gif" is_valid="1">
															<input type="hidden" name="ba_image_h" id="ba_image_h" class="hiddenfile" preview="true" path=""> 
														<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG, GIF </small>
														<br><span id="ba_image_err" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											

											<input type="hidden" name="ba_id" value="<?php echo $ba['ba_id']; ?>">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Banner Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input  name="ba_name" id="ba_name" class="form-control" placeholder="Banner Name" type="text" value="<?php echo $ba['ba_name']; ?>">
														</div>
														<span id="ba_name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Banner Type</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
															<select class="form-control js-example-basic-single" name="ba_bannertype" id="ba_bannertype">
																<option value="">Please Select</option>
																<option value="Top" <?php if($ba['ba_bannertype']=="Top"){ echo "selected";} ?>>Top</option>
																<option value="Right" <?php if($ba['ba_bannertype']=="Right"){ echo "selected";} ?>>Right</option>
															</select>
														</div>
															<span id="bannertype_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Intended User</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<?php if($ba['ba_roles_id']=="1"){ $userrole = "ETA";  }
															 elseif($ba['ba_roles_id']=="2"){ $userrole = "Licensees"; }
															 elseif($ba['ba_roles_id']=="3"){ $userrole = "Industry Associations"; }
															 elseif($ba['ba_roles_id']=="4"){ $userrole = "Consumers";  } 
															 elseif($ba['ba_roles_id']=="5"){ $userrole = "Suppliers";  } ?>
															
															<input  class="form-control" type="text" value="<?php echo $userrole; ?>"  readonly>
															
														</div>
														<span id="ba_roles_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Link</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-film"></i></span>
															<input  name="ba_link" id="ba_link" class="form-control" type="text" placeholder="Link" value="<?php echo $ba['ba_link']; ?>">
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
																<option value="1" <?php if($ba['ba_status']=="1"){ echo "selected";} ?>>Published</option>
																<option value="0" <?php if($ba['ba_status']=="0"){ echo "selected";} ?>>Draft</option>
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
															<input  name="publish_date" id="publish_date" class="form-control datepicker" type="text" placeholder="Publish Date" value="<?php if($ba['ba_publish_date'] !='0000-00-00 00:00:00'){ echo date('m/d/Y', strtotime($ba['ba_publish_date'])); } ?>">
														</div>
															<span id="date_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<!-- <div class="col-md-6">
													<div class="form-group required">
														<label>Visibility</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
															<select class="form-control js-example-basic-single" name="ba_visibility" id="ba_visibility">
																<option value="">Please Select</option>
																<option value="1" <?php if($ba['ba_visibility']=="1"){ echo "selected";} ?>>Active</option>
																<option value="0" <?php if($ba['ba_visibility']=="0"){ echo "selected";} ?>>Inactive</option>
															</select>
														</div>
															<span id="visible_err" class="invalidText"></span>
													</div>
												</div> -->

												<div class="col-md-6 col-md-offset-6">
													<div class="form-group">
														
															<input type="checkbox" name="target" value="_blank" <?php if($ba['ba_target']){echo 'checked= checked';} ?>> Open link in new tab
														
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