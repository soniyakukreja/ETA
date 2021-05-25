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
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong> Indicates a warning that might need attention.
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong> Indicates a successful or positive action.
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'add_licbusiness','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Title <span></span></label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="busrev_title" id="busrev_title" class="form-control" placeholder="Title" value="" type="text" autocomplete="off">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>	
												</div>
												
											</div>
											
											<div class="row">
												<div class="col-md-6">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group required">
																	<label>Due Date</label>
																	<div class="dateInput"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-calendar"></i></span>
																		<input name="busrev_duedate" id="busrev_duedate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" >
																	</div>
																	<span id="lic_startdate_err" class="invalidText"></span>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group required">
																	<label>Date Completed</label>
																	<div class="dateInput"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-calendar"></i></span>
																		<input name="busrev_complete" id="busrev_complete" class="form-control datepicker datepicker_to" type="text" onkeydown="event.preventDefault()"  autocomplete="off">
																	</div>
																	<span id="lic_enddate_err" class="invalidText"></span>
															</div>
															</div>
														</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Business Review File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input name="busrev_file" is_valid="1" id="busrev_file" class="form-control" value="" type="file" accept=".pdf"  autocomplete="off">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>PDF Files Only</label>
														<span id="lic_file_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
														<div class="form-group required">
															<label>Status</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<select class="form-control js-example-basic-single" name="busrev_status" id="busrev_status">
																  <option value="">Please Select</option>
																  <option value="Pending">Pending</option>
																  <option value="Complete">Complete</option>
																  <option value="Late">Late</option>
																  
																</select>
															</div>
															<span id="country_err" class="invalidText"></span>
														</div>
													</div>
													
											</div>
											<div class="row">
												<button type="submit">Submit</button>
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