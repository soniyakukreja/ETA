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
										<h3>Edit Deals</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                      						<strong>Warning!</strong>
                    					</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      						<strong>Success!</strong>
                    					</div>
                    					<?php //echo "<pre>"; print_r($data); exit; ?>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_deal','autocomplete'=>'off')); ?>
										
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $data['deal_id']; ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Deal Title</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="deal_title" id="deal_title" class="form-control" placeholder="Name" value="<?php echo $data['deal_title']; ?>" type="text"  autocomplete="off"> 
														</div>
														<span id="deal_title_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Person</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="cp_name" id="cp_name_editdeal" class="form-control" deal="<?php echo $data['deal_id']; ?>" placeholder="Contact Person" autocomplete="off" value="<?php echo $data['contact_person']; ?>" type="text">
															<input type="hidden" name="contact_id"  id="contact_id" value="<?php echo $data['contact_id']; ?>">
															<input type="hidden" name="business_id" id="business_id" value="<?php echo $data['business_id']; ?>">
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="cpContainer">
															</ul>
														</div>														
														<span id="cp_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row" id="businessDivOne" style="display:block;">
												<div class="col-md-12">
													<div class="form-group required">
														<label>Business</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="bus_name_poped" id="bus_name_poped" class="form-control" type="text" value="<?php echo strval($data['business_name']); ?>"  onkeydown="event.preventDefault()">
														</div>											
														<span id="business_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<?php /*
											<div id="addbusinessDiv" <?php if($data['business_id']!=''){ echo "style='display:block;'";}else{echo "style='display:none;'";} ?>>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Business</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="bus_name" id="bus_name" class="form-control" placeholder="Business Name" autocomplete="off" value="<?php echo $data['business_name'] ?>" type="text">
															</div>											
															<span id="business_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address</label>
															<div class="input-group">
																<textarea name="address" id="address" cols="50" row="2"><?php echo $data['business_street1'] ?></textarea>
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
																<input type="text" name="suburb" id="suburb" class="form-control" placeholder="suburb/Province" value="<?php echo $data['business_suburb']; ?>"> 
															</div>
															<span id="suburb_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group required">
															<label>Postcode </label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="postcode" id="postcode" class="form-control" placeholder="Postcode" type="text" value="<?php echo $data['business_postalcode']; ?>">
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
																	<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$data['business_country']){echo "selected";} ?>><?php echo $value['country_name']; ?></option>
																  <?php } } ?>
																</select>
															</div>
															<span id="country_err" class="invalidText"></span>
														</div>
														
													</div>
												</div>
											</div>	
											*/ ?>
											<div class="row">	
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Deal Value (In USD)</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-usd"></i></span>
															<input  name="deal_value" id="deal_value" class="form-control" type="number" placeholder="Deal Value" autocomplete="off" value="<?php echo $data['deal_value'] ?>">
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
																	 <option value="<?php echo $value['pstage_id']; ?>" <?php if ($value['pstage_id']== $data['pstage_id']){ echo "selected";} ?> ><?php echo $value['pstage_name']; ?></option>
																<?php 	}
																} ?>
															</select>
															
														</div>
														<span id="stage_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Expected Close date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="close_date" id="close_date" class="form-control dpic_dsbl_prev" type="text" value="<?php if($data['deal_exp_closedate'] !='0000-00-00 00:00:00'){ echo date('m/d/Y',strtotime($data['deal_exp_closedate'])); } ?>">
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
															<textarea name="notes" id="notes" cols="100%" row="5"><?php echo $data['deal_notes'] ?></textarea>
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