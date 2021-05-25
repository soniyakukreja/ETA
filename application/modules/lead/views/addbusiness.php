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
										<h3>Business</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          						<strong>Warning!</strong>
                                        					</div>
                                        					<div id="successMsg" class="alert alert-success hide">
                                          						<strong>Success!</strong>
                                        					</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_business','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="bus_name" id="bus_name" class="form-control" placeholder="Business Name" value="" type="text">
														</div>
														<span id="bus_name_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Phone Number</label>
														
														<div class="inputGroup">
															<input type="text" class="form-control" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="inputTel" >
														    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review">test1</button>
														    <span id="valid-msg" class="hide" style="color:#67cc19">✓ Valid</span>
															<span id="error-msg" class="hide" style="color:#ea0909"></span>
														    <div id="phone_codes"></div>
														    <div id="error_four" style="margin-top: 8px;"></div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Website</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="website" id="website" class="form-control"  value="" type="text" placeholder="Website">
														</div>
														<span id="website_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Street Address 1</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-road"></i></span>
															<input name="address" id="address" class="form-control"  value="" type="text" placeholder="Address ">
														</div>
														<span id="address_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Street Address 2</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-road"></i></span>
															<input name="address_two" id="address_two" class="form-control"  value="" type="text" placeholder="Address ">
														</div>
														
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Suburb/Province</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-map-marker"></i></span></span>
															<input name="suburb" id="suburb" class="form-control"  value="" type="text" placeholder="Suburb/Province ">
														</div>
														<span id="suburb_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group ">
														<label>State/Region</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="fa fa-globe" aria-hidden="true"></i></span>
															<input name="state" id="state" class="form-control"  value="" type="text" placeholder="State">
														</div>
													</div>
												</div>												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Postcode </label>
														<div class="input-group"><span class="input-group-addon">
															<i class="fa fa-lock" aria-hidden="true"></i></span>
															<input name="postcode" id="postcode" class="form-control" placeholder="Postcode"type="text">
														</div>
														<span id="postcode_err" class="invalidText"></span>
													</div>	
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Country</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
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
												<?php         
												$dept_id = $this->userdata['dept_id'];
       
        										if($dept_id==1 ||$dept_id==2||$dept_id==10){ ?>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Assign To BDE</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<select class="form-control js-example-basic-single" name="assign_to" id="assign_to">
															  <option value="">Please Select</option>
															  <?php if(!empty($bde_list)){  foreach($bde_list as $value){ ?>
																<option value="<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="country_err" class="invalidText"></span>
													</div>
												</div>
												<?php } ?>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>Notes</label>
														<div class="inputGroup">
															<textarea name="notes" rows="5" cols="100%"></textarea>
														</div>
													</div>
												</div>
												<div class="col-md-6"></div>
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
<?php $this->load->view('include/footer.php'); ?>
<?php $this->load->view('lead/lead_js.php'); ?>
</div>
</body>
</html>