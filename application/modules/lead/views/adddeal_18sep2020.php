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
										<h3>Deals</h3></br>
										<div id="errorMsg" class="alert alert-danger hide"></div>
                        				<div id="successMsg" class="alert alert-success hide"></div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_deal','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Deal Title</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="deal_title" id="deal_title" class="form-control" placeholder="Name" value="" type="text"  autocomplete="off"> 
														</div>
														<span id="deal_title_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Person</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="cp_name" id="cp_name" class="form-control" placeholder="Contact Person" autocomplete="off" value="" type="text">
															<input type="hidden" name="contact_id" id="contact_id">
															<input type="hidden" name="business_id" id="business_id">
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="cpContainer">
															</ul>
														</div>														
														<span id="cp_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row" id="businessDivOne" style="display:none;">
												<div class="col-md-12">
													<div class="form-group required">
														<label>Business</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="bus_name_poped" id="bus_name_poped" class="form-control" disabled="disabled" type="text">
														</div>											
													</div>
												</div>
											</div>
											<div id="addbusinessDiv" style="display:none;">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Contact Email Address</label>
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
													<div class="col-md-6">
														<div class="form-group required">
															<label>Business</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="bus_name" id="bus_name" class="form-control" placeholder="Business Name" autocomplete="off" value="" type="text">
															</div>											
															<span id="business_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address 1</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-retweet"></i></span>
																<input name="address" id="address" class="form-control"  value="" type="text" placeholder="Address ">
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb/Province</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input type="text" name="suburb" id="suburb" class="form-control" placeholder="Suburb/Province"> 
															</div>
															<span id="suburb_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group required">
															<label>Postcode </label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="postcode" id="postcode" class="form-control" placeholder="Postcode"type="text">
															</div>
															<span id="postcode_err" class="invalidText"></span>
														</div>	
													</div>
													<div class="col-md-3">
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
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Deal Value (In USD)</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="deal_value" id="deal_value" class="form-control" type="number" placeholder="Deal Value" autocomplete="off">
														</div>
														<span id="dealval_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Stage</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="stage" id="stage">
																<option value="">Please Select</option>
																<?php if (isset($stages)) {
																	foreach ($stages as $value) { ?>
																	 <option value="<?php echo $value['pstage_id']; ?>"><?php echo $value['pstage_name']; ?></option>
																<?php 	}
																} ?>
															 
															</select>
														</div>
														<span id="stage_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<?php /*
												<div class="col-md-6">
													<div class="form-group">
														<label>Age</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calander"></i></span>
															<input name="age" id="age" class="form-control" value="" type="number" placeholder="Deal age" autocomplete="off">
														</div>
														<span id="phone_err" class="invalidText"></span>
													</div>
												</div>*/ ?>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Expected Close Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="close_date" id="close_date" class="form-control dpic_dsbl_prev" type="text" placeholder="Expected Close Date"  onkeydown="event.preventDefault()" autocomplete="off" >
														</div>
														<span id="closedate_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-12">
													<div class="form-group">
														<label>Additional Information</label>
														<div class="inputGroup">
															<textarea name="notes" id="notes" rows="5" cols="100%"></textarea>
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
<?php $this->load->view('lead/lead_js'); ?>
</div>
</body>
</html>