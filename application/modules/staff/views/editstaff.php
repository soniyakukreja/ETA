<?php $this->load->view('include/header'); ?>
<?php $dept = $this->session->userdata['userdata']['dept_id']; //print_r($this->session->userdata['userdata']); ?>
<style>
	.addNew {
		position: unset;
	}
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
										<h3>Edit Staff</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong> Indicates a warning that might need attention.
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong> Indicates a successful or positive action.
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_staff','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($data['profilepicture'])){ echo base_url('uploads/user/').$data['profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width:200px; height: 200px; margin-bottom: 20px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h" preview="true" path="cto_profile" class="hiddenfile">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="ba_image_err" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											<br>											
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $data['user_id']; ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>First Name <span></span></label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="firstname" id="firstname" class="form-control" placeholder="First Name" value="<?php echo $data['firstname']; ?>" type="text">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Last Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo $data['lastname']; ?>" type="text">
														</div>
														
														<span id="lastname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Email Address</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" class="form-control"  value="<?php echo $data['email']; ?>" type="email" placeholder="Email Address">
														</div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Contact Number</label>
														<div class="inputGroup">
															<input type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control" value="<?php if(!empty($data['contactno'])){ echo trim($data['contactno']);} ?>">
														    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review">test1</button>
														    <span id="valid-msg" class="hide" style="color:#67cc19">✓ Valid</span>
															<span id="error-msg" class="hide" style="color:#ea0909"></span>
														    <div id="phone_codes"></div>
														    <div id="error_four" style="margin-top: 8px;"></div>
														</div>
														<span id="contactno_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Country</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="country" id="country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$data['country']){echo "selected";} ?>><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="country_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Department</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															
															<select class="form-control js-example-basic-single" <?php if(!in_array($dept,array('1','2','10'))){ echo 'disabled=""'; }else{ echo 'name="dept"'  ;} ?> id="dept" >
																<option value="">Please Select</option>
																<?php if(!empty($deptlist)){  foreach($deptlist as $value){ ?>
																<option value="<?php echo $value['dept_id']; ?>" <?php if($value['dept_id']==$data['dept_id']){echo "selected";} ?>><?php echo $value['deptname']; ?></option>
															  	<?php } } ?>
															</select>
														</div>
														<span id="dept_err" class="invalidText"></span>
													</div>
												</div>												
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group required" style="<?php if($data['dept_id']==4){ echo 'display:block;'; }else{ echo 'display:none;'; } ?>" id="assignDiv">
														<label>Assign To</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="assign_to" id="assign_to">
																<option value="">Please Select</option>
																<?php if(!empty($kam_list)){ foreach($kam_list as $kam){ ?>
																<option value="<?php echo $kam['user_id']; ?>" <?php if($kam['user_id']==$data['assign_to']){ echo 'selected'; } ?> ><?php echo $kam['username']; ?></option>
																<?php } } ?>
															</select>
														</div>
														<span id="assign_to_err" class="invalidText"></span>
													</div>
												</div>	
											</div>	

											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Time Zone</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<?php $OptionsArray = timezone_identifiers_list(); ?>
															 <select select class="form-control js-example-basic-single" name="timezone" id="timezone">
															 	<option value="">Please Select</option>
														      <?php   foreach ($OptionsArray as $key => $row ){ ?>
														            <option value="<?php echo $row; ?>" <?php if($data['timezone']==$row){ echo "selected";} ?>><?php echo $row; ?>
														            </option>
														        
															<?php } ?>
														        </select>
														</div>
														<span id="timezone_err" class="invalidText"></span>
													</div>
												</div>
											</div>

											<br>										
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
<?php $this->load->view('staff/staff_js.php'); ?>
</div>
</body>
</html>