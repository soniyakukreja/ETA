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
										<h3>Contact Person Details</h3></br>
										<div id="errorMsg" class="alert alert-danger hide"></div>
                                        <div id="successMsg" class="alert alert-success hide"></div>
										
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_contact','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="person" id="person" class="form-control" placeholder="Name" value="" type="text"  autocomplete="off"> 
															<input type="hidden" id="cp_id" name="cp_id"> 
															<input type="hidden" id="cp_name" name="cp_name"> 
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="cpContainer">
															</ul>
														</div>
														<span id="person_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="bus_name" id="cp_business" class="form-control" placeholder="Business Name" autocomplete="off" value="" type="text" msg="">
															<input type="hidden" name="business_id" id="business_id">
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="busContainer">
															</ul>
														</div>														
														<span id="business_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div id="businessDiv" style="display:none;">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address</label>

															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input name="address" id="address" class="form-control"  value="" type="text" placeholder="Address ">
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb/Province</label>

															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-retweet"></i></span>
																<input name="suburb" id="suburb" class="form-control"  value="" type="text" placeholder="Suburb/Province ">
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
																<i class="glyphicon glyphicon-list-alt"></i></span>
																<input name="postcode" id="postcode" class="form-control" placeholder="Postcode"type="text">
															</div>
															<span id="postcode_err" class="invalidText"></span>
														</div>	
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Country</label>
															<div class="input-group"><span class="input-group-addon"><div class="iti-flag us"></div>
																</span>
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
												<div class="col-md-6">
													<div class="form-group required">
														<label>Email Address</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" class="form-control"  value="" type="email" placeholder="Email Address"  autocomplete="off">
														</div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Contact Number</label>
														<div class="inputGroup">
															<input type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control">
														    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review">test1</button>
														    <span id="valid-msg" class="hide" style="color:#67cc19">✓ Valid</span>
															<span id="error-msg" class="hide" style="color:#ea0909"></span>
														    <div id="phone_codes"></div>
														    <div id="error_four" style="margin-top: 8px;"></div>
														</div>
														<span id="phone_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>Notes</label>
														<div class="inputGroup">
															<textarea name="notes" rows="5" cols="100%"  autocomplete="off"></textarea>
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
										<input type="hidden" id="cp_business_id" />
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
<?php //$this->load->view('lead/lead_js.php'); ?>
<script type="text/javascript" src="<?php echo base_url('includes/js/cp.js'); ?>"></script>

</div>
</body>
</html>