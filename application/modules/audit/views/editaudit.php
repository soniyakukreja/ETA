<?php $this->load->view('include/header.php'); ?>
<style>
	.expBtn a.addNew {
		position: inherit;
	}
</style>
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
									<div class="filterDiv expBtn">
										<h3>Edit Audit</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                      					<strong>Warning!</strong>
                   						</div>
                    					<div id="successMsg" class="alert alert-success hide">
                      					<strong>Success!</strong>
                    					</div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_audit','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php ?>">
												<div class="col-md-6">
													<input type="hidden" name="id" value="<?php echo $ad['ord_prod_id']; ?>">
													<div class="form-group">
														<label>Audit Number</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="num" id="num" class="form-control" placeholder="Name"  value="<?php echo $ad['audit_num']; ?>" type="text" readonly></div>
														<span id="num_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="businessname" id="businessname" class="form-control" placeholder="Business Name"  value="<?php echo $ad['businessname']; ?>" type="text" maxlength="70" minlength="2" readonly></div>
														<span id="businessname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Last Updated Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="updateddate" id="updateddate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" value="<?php if($ad['updatedate']!='0000-00-00 00:00:00'){ echo date('m/d/Y',strtotime($ad['updatedate']));} ?>" disabled placeholder="Last Updated Date">
														</div>
														<span id="updateddate_err" class="invalidText"></span>
													</div>
												</div>

												<?php if($this->userdata['urole_id']==1){ ?>
												<div class="col-md-6">
													<div class="form-group <?php if($this->userdata['urole_id']==1){ echo 'required'; } ?>">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="status" id="status">
															  <option value="2" <?php if($ad['status']==2){echo "selected";} ?>>Pending Certificate</option>
															  <option value="3" <?php if($ad['status']==3){echo "selected";} ?>>Approve</option>
															  <option value="4" <?php if($ad['status']==4){echo "selected";} ?>>Deny</option>
															</select>
														</div>
														<span id="status_err" class="invalidText"></span>
													</div>
												</div>
												
												<?php }else{ ?>

													<div class="col-md-6">
														<div class="form-group">
															<label>Status</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-th-list"></i></span>
																<select class="form-control js-example-basic-single" name="status"  id="status">
																  <option value="0" <?php if($ad['status']==0){echo "selected";} ?>>Pending Audit</option>
																  <option value="1" <?php if($ad['status']==1){echo "selected";} ?>>Pending Review</option>
																  <option value="2" <?php if($ad['status']==2){echo "selected";} ?>>Pending Certificate</option>
																  
																</select>
															</div>
															<span id="status_err" class="invalidText"></span>
														</div>
													</div>
												<?php } ?>
											</div>
											<?php  if($this->userdata['urole_id']==1){ ?>
											<div class="row">

												<div class="col-md-6">
													<div class="form-group required">
														<label>Issue Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="issue_date" id="issue_date" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" value="<?php if($ad['issue_date']!='0000-00-00 00:00:00' && $ad['issue_date']!='1970-01-01 00:00:00'){ echo date('m/d/Y',strtotime($ad['issue_date']));} ?>" placeholder="Issue Date">
														</div>
														<span id="issue_date_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>End Date</label>
														<div class="dateInput"><span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i></span>
															<input name="end_date" id="end_date" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()"  autocomplete="off" value="<?php if($ad['end_date']!='0000-00-00 00:00:00' && $ad['issue_date']!='1970-01-01 00:00:00'){ echo date('m/d/Y',strtotime($ad['end_date']));} ?>" placeholder="End Date">
														</div>
														<span id="end_date_err" class="invalidText"></span>
													</div>
												</div>
												
											</div>
											<?php } ?>
		
												
											<div class="row">

													<?php $this->userdata = $this->session->userdata('userdata'); if($this->userdata['urole_id']==5){ ?>
												<div class="col-md-6">
													<div class="form-group required">
														<label>File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="file" id="file" class="form-control"  type="file" accept=".pdf"  autocomplete="off">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<b style="font-size:12px;">PDF Files Only</b><br>

														<span id="file_err" class="invalidText"></span>
													</div>
												</div>
													<?php } ?>
													<?php  if($this->userdata['urole_id']==1){ ?>
												<div class="col-md-6">
													<div class="form-group">
														<label>Certificate File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="certificate_file" id="certificate_file" class="form-control"  type="file" accept=".pdf"  autocomplete="off">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>PDF Files Only</label>
														<br>
														<span id="certificate_file_err" class="invalidText"></span>
													</div>
												</div>
											<?php } ?>												
												
											</div>
											
											<div class="row">
												<input type="hidden" id="urole_id" value="<?php echo $this->userdata['urole_id']; ?>">

<?php if($this->userdata['urole_id']==5 && ($ad['status']==0||$ad['status']==1||$ad['status']==4)){ ?>
	<button type="submit" style="margin-right: 17px;"  class="addNew sup_submtbtn" id="submitbtn">Submit</button>
<?php }elseif($this->userdata['urole_id']==1 && $ad['status']!=3){ ?>
	<button type="submit" style="margin-right: 17px;"  class="addNew" id="submitbtn">Submit </button>
<?php } ?>												
							
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
	<?php //$this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer.php'); ?>
<script>

$('#status').on('change',function(){
	if($(this).val()==2){
		$('.sup_submtbtn').html('Submit Audit to ETA');
	}else{
		$('.sup_submtbtn').html('Submit');
	}
});
</script>
</div>
</body>
</html>