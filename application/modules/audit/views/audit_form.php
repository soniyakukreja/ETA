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
										<h3>Add Audit:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                      					<strong>Warning!</strong>
                   						</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      					<strong>Success!</strong>
                    					</div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('audit/addaudit',array('class'=>'addForm','id'=>'add_audit','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Audit Number</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="num" id="num" class="form-control" placeholder="Name"  value="" type="text"></div>
														<span id="num_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="businessname" id="businessname" class="form-control" placeholder="Business Name"  value="" type="text" maxlength="70" minlength="2"></div>
														<span id="businessname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Last Updated Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="updateddate" id="updateddate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" >
														</div>
														<span id="updateddate_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Issue Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="issue_date" id="issue_date" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" >
														</div>
														<span id="issue_date_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>End Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="end_date" id="end_date" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" >
														</div>
														<span id="end_date_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="file" id="file" class="form-control" type="file" accept=".pdf"  autocomplete="off">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>PDF Files Only</label>
														<span id="file_err" class="invalidText"></span>
													</div>
												</div>
											</div>
		
												
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Certificate File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="certificate_file" id="certificate_file" class="form-control" type="file" accept=".pdf"  autocomplete="off">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>PDF Files Only</label>
														<span id="certificate_file_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="status" id="status">
																<option value="">Please Select</option>
															  <option value="0">Pending Audit</option>
															  <option value="1">Pending Review</option>
															  <option value="2">Pending Certificate</option>
															</select>
														</div>
														<span id="status_err" class="invalidText"></span>
													</div>
												</div>
												
												
											</div>
											
											
											
											<div class="row">
												<button type="submit" style="margin-right: 17px;">Submit</button>
							
												<a href="javascript:window.history.go(-1);" class="addNew">Back</a>
											</div>
											<?php echo form_close(); ?>
										<!-- </form> -->
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
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>