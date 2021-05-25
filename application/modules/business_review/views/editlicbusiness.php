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
								
                        			<?php $this->load->view('include/leftsidebar'); ?>
                        	
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Edit Business Review</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong> Indicates a warning that might need attention.
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong> Indicates a successful or positive action.
										</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'editlicbusiness','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $lic['busrev_id'] ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Title <span></span></label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="busrev_title" id="busrev_title" class="form-control" placeholder="Title" value="<?php echo $lic['busrev_title'] ?>" type="text" autocomplete="off" disabled>
														</div>
														<span id="busrev_title_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
														<div class="form-group required">
															<label>Type</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<select class="form-control js-example-basic-single" name="busrev_type" id="busrev_type" disabled>
																  <option value="">Please Select</option>
																  <option value="MBR" <?php if($lic['busrev_type']=="MBR"){echo "selected";} ?>>MBR</option>
																  <option value="QBR" <?php if($lic['busrev_type']=="QBR"){echo "selected";} ?>>QBR</option>
																  <option value="YBR" <?php if($lic['busrev_type']=="YBR"){echo "selected";} ?>>YBR</option>
																  
																</select>
															</div>
															<span id="busrev_type_err" class="invalidText"></span>
														</div>
													</div>
												
											</div>
											
											<div class="row">
												
															<div class="col-md-6">
																<div class="form-group required">
																	<label>Due Date</label>
																	<div class="dateInput"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-calendar"></i></span>
																		<input name="busrev_duedate" id="busrev_duedate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" value="<?php echo date('m/d/Y',strtotime($lic['busrev_duedate'])); ?>" disabled>
																	</div>
																	<span id="lic_startdate_err" class="invalidText"></span>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Business Review File</label>
																	<div class="input-group"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-file"></i></span>
																		<input  name="busrev_file" id="busrev_file" class="form-control pdffile" value="" type="file" accept=".pdf"  autocomplete="off" is_valid="1">
																		<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
																	</div>
																	<label>Only Supported File is PDF</label>
																	<span id="busrev_file_err" class="invalidText pdferror"></span>
																</div>
															</div>
															
												</div>
											
											<div class="row">
												
												<div class="col-md-6">
														<div class="form-group required">
															<label>Status</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<select class="form-control js-example-basic-single" name="busrev_status" id="busrev_status">
																  <option value="">Please Select</option>
																  <option value="Pending" <?php if($lic['busrev_status']=="Pending"){echo "selected";} ?>>Pending</option>
																  <option value="Completed" <?php if($lic['busrev_status']=="Completed"){echo "selected";} ?>>Completed</option>
																  <option value="Late" <?php if($lic['busrev_status']=="Late"){echo "selected";} ?>>Late</option>
																  
																</select>
															</div>
															<span id="busrev_status_err" class="invalidText"></span>
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
<?php //$this->load->view('include/crop_image_modal'); ?>
<script src="<?php echo base_url('includes/js/'); ?>phonevalidation.js"></script>	
<?php $this->load->view('include/footer'); ?>
<?php $this->load->view('staff/staff_js'); ?>

</div>
</body>
</html>