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
										<p class="toAdd">To add a new Industry Association, you must enter the following details.</p>
										
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>

										<?php echo form_open('',array('class'=>'addForm','id'=>'add_ia','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Industry Association Licence Number</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
															<input  name="lic_number" id="lic_number" placeholder="Industry Association Licence Number" class="form-control" type="text">
														</div>
														<span id="lic_number_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group required">
																<label>Industry Association Licence Start Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_startdate" id="lic_startdate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()" placeholder="Start Date">
																</div>
																<span id="lic_startdate_err" class="invalidText"></span>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group required">
																<label>Industry Association Licence End Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_enddate" id="lic_enddate" class="form-control datepicker datepicker_to" type="text" onkeydown="event.preventDefault()" placeholder="End Date">
																</div>
																<span id="lic_enddate_err" class="invalidText"></span>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Assign To</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="assign_to" id="assign_to"  autocomplete="off" >
															  <option value="">Please Select Kam</option>
															  <?php if(!empty($kam_list)){  foreach($kam_list as $value){ ?>
																<option value="<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></option>
															  <?php } } ?>
															</select>
														</div>	
														<span id="assign_to_err" class="invalidText"></span>												
													</div>													
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Award Levels</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="category" id="category"  autocomplete="off" >
															  <option value="">Please Select</option>
															  <?php if(!empty($categorylist)){  foreach($categorylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
															  <?php } } ?>
															</select>
														</div>													
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
														<br><span id="" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											<hr>
											<div class="row"><div class="col-md-6"><p class="toAdd">CTO Detail</p>
											</div></div>												
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO First Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="firstname" id="firstname" class="form-control" placeholder="CTO First Name" type="text">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Last Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<input  name="lastname" id="lastname" class="form-control" placeholder="CTO Last Name" type="text">
														</div>
														<span id="lastname_err" class="invalidText"></span>
													</div>
												</div>
											</div>																						
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Email Address</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" class="form-control" value="" type="email" placeholder="CTO Email Address">
														</div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Contact Number</label>
														<div class="inputGroup">
															<input type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control">
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
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="ia_country" id="ia_country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>"><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="ia_country_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>CTO Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="cto_profilepicture" id="cto_profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png"  is_valid="1">
															<input type="hidden" name="cto_profilepicture_h" id="cto_profilepicture_h" class="hiddenfile">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="" class="invalidText image_err"></span>
													</div>
												</div>												
											</div>

											<div class="row">
												
												<div class="col-md-6"></div>
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
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="password" id="password" class="form-control no-paste" placeholder="Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)">
															<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
														</div>
														<span id="p_err" class="invalidText" style="display:none;"></span>
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
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" value="" type="password" onpaste="return false;" onkeyup="return validate_pass(this)">
															<span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
														</div>
														<span id="cp_err" class="invalidText" style="display:none;"></span>
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
														            <option value="<?php echo $row; ?>"><?php echo $row; ?>
														            </option>
														        
															<?php } ?>
														        </select>
														</div>
														<span id="timezone_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											
											<hr>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<?php if(!empty($businessData)){ ?>
																<input name="business_name"  class="form-control" placeholder="Business Name" autocomplete="off"  value="<?php echo $businessData['business_name']; ?>" onkeydown="event.preventDefault()" type="text">
																<input type="hidden" name="business_id" id="business_id" value="<?php echo $businessData['business_id']; ?>">
															<?php }else{ ?>
																<input name="business_name" id="ia_business" class="form-control" placeholder="Business Name" autocomplete="off" value="" type="text">
																<input type="hidden" name="business_id" id="business_id">
															<?php } ?>
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="busContainer">
															</ul>
														</div>														
														<span id="business_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div id="businessStDiv" style="display:none;">
														<div class="form-group required">
															<label>State/Region</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input name="state" id="state" class="form-control" value="" type="text" placeholder="State">
															</div>
															<span id="state" class="invalidText"></span>
														</div>
													</div>
												</div>
											</div>

											<div id="businessDiv" style="display:none;">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address</label>
															<div class="input-group">
																<!-- <textarea name="address" id="address" cols="50" row="2"></textarea> -->
																<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
																<input name="address" id="address" class="form-control" placeholder="Address"type="text">
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb/Province</label>
															<div class="input-group">

																<!-- <textarea name="suburb" id="suburb" cols="50" row="2"></textarea> -->
																<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
																<input name="suburb" id="suburb" class="form-control" placeholder="Suburb/Province" type="text">
															</div>
															<span id="suburb_err" class="invalidText"></span>
														</div>
													</div>
												</div>
												<div class="row">												
													<div class="col-md-6">
														<div class="form-group required">
															<label>Postcode </label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="postcode" id="postcode" class="form-control" placeholder="Postcode"type="text">
															</div>
															<span id="postcode_err" class="invalidText"></span>
														</div>	
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Country</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
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
<?php $this->load->view('include/footer.php'); ?></div>
<?php $this->load->view('industryassociation/ia_js.php'); ?>
</body>
</html>