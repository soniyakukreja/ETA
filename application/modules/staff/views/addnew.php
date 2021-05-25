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
								<?php $this->load->view('include/leftsidebar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<p class="toAdd">To add a new Staff, you must enter the following details.</p>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong> Indicates a warning that might need attention.
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong> Indicates a successful or positive action.
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_staff','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>First Name <span></span></label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="firstname" id="firstname" class="form-control" placeholder="First Name" value="" type="text" autocomplete="off">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Last Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="" type="text" autocomplete="off">
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
															<input name="email" id="email" class="form-control"  value="" type="email" placeholder="Email Address" autocomplete="false">
														</div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Contact Number</label>
														<div class="inputGroup">
															<input autocomplete="off" type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control">
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
																<option value="<?php echo $value['id']; ?>"><?php echo $value['country_name']; ?></option>
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
															<select class="form-control js-example-basic-single" name="dept" id="dept">
																<?php $this->load->view('include/roles'); ?>
															</select>
														</div>
														<span id="dept_err" class="invalidText"></span>
													</div>
												</div>												
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Password </label>
														<div class="input-group"><span class="input-group-addon"  
title="Minimum 8 characters in length
Contains 3/4 of the following items:
- Uppercase Letters
- Lowercase Letters
- Numbers
- Symbols">
															<i class="glyphicon glyphicon-lock"></i></span>
															<input name="password" id="password" class="form-control no-paste" placeholder="Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)" autocomplete="off">
															<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
														</div>
														<span id="p_err" class="invalidText"  style="display:none"></span>
														<div class="strongWeak" id="pass_err" style="display:none;">
															<div class="w3-border">
																<div class="stren_line" style="height:5px;width:20%;background: red;"></div>
															</div>
															<span class="stren_text">Weak</span>
														</div>
													</div>	

												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Confirm Password</label>
														<div class="input-group"><span class="input-group-addon"
title="Minimum 8 characters in length
Contains 3/4 of the following items:
- Uppercase Letters
- Lowercase Letters
- Numbers
- Symbols">
															<i class="glyphicon glyphicon-lock"></i></span>
															<input  name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)">
															<span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
														</div>
														<span id="cp_err" class="invalidText" style="display:none"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h" class="hiddenfile">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br>
														<span id="ba_image_err" class="invalidText image_err"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required" style="display:none;" id="assignDiv">
														<label>Assign To</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="assign_to" id="assign_to">
																<option value="">Please Select</option>
																<?php if(!empty($kam_list)){ foreach($kam_list as $kam){ ?>
																<option value="<?php echo $kam['user_id']; ?>"><?php echo $kam['username']; ?></option>
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
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
															<?php $OptionsArray = timezone_identifiers_list(); ?>
															 <select select class="form-control js-example-basic-single" name="timezone" id="timezone">
															 	<option value="">Please Select</option>
														      <?php   foreach ($OptionsArray as $key => $row ){ ?>
														            <option value="<?php echo $row; ?>"><?php echo $row; ?>
														            </option>
														        
															<?php } ?>
														        </select>
														</div>
														<span id="timezone_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<button type="submit" style="margin-right: 17px;" class="addNew">Submit</button>
							
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
<script src="<?php echo base_url('includes/js/'); ?>phonevalidation.js"></script>	
<?php $this->load->view('include/footer'); ?>
<?php $this->load->view('staff/staff_js'); ?>

</div>
</body>
</html>