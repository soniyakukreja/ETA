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
								<div class="aside">
								<?php $this->load->view('include/leftsidebar.php'); ?>
								</div>
								<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $ia['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $ia['country'], $returnType = 'array');
								 ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Licensee Details:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php echo form_open('',array('class'=>'editForm','id'=>'edit_licensee','enctype'=>'multipart/form-data')); ?>
										
										<div class="linDeta">
											<table class="table">
												<tbody>
													<input type="hidden" name="id" value="<?php echo $ia['lic_id']; ?>">
													<tr>
														<th>License Number</th>
														<td><div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
															<input  name="lic_number" id="lic_number" placeholder="Industry Association Licence Number" class="form-control" type="text" value="<?php echo $ia['lic_number']; ?>">
														</div><span id="lic_number_err" class="invalidText"></span></td>
														<th>License Date</th>
														<td><label> Start Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_startdate" id="lic_startdate" class="form-control datepicker datepicker_to" type="text" value="<?php echo date('m-d-Y', strtotime($ia['lic_startdate']))?>" style="width: 100px;">
															<label> End Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_enddate" id="lic_enddate" class="form-control datepicker datepicker_to" type="text" value="<?php echo date('m-d-Y', strtotime($ia['lic_enddate']))?>">		
																</div></td>
													</tr>
													<tr>
														<th>CTO Name</th>
														<td><div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="firstname" id="firstname" class="form-control" placeholder="CTO First Name" type="text" value="<?php echo $ia['firstname']; ?>">
														</div><span id="firstname_err" class="invalidText"></span></td>
														<th>Business Name</th>
														<td><div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="business_name" id="business_name" class="form-control" placeholder="Business Name" value="<?php echo $ia['business_name']; ?>" type="text">
														</div> 
														</td>
													</tr>
													
													<tr>
														<th>CTO Email Address</th>
														<td><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" class="form-control" value="<?php echo $ia['email']; ?>" type="email" placeholder="CTO Email Address">
														</div><span id="email_err" class="invalidText"></span></td>
														<th>CTO Contact Number</th>
														<!-- <td><div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-earphone"></i></span>
															<input  name="contactno" id="contactno" class="form-control" value="<?php echo $ia['contactno']; ?>" type="text" placeholder="CTO Contact Number" maxlength="12" minlength="8">
														</div></td> -->
														<td><div class="inputGroup">
															<input type="text" class="form-control" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="inputTel" value="<?php echo $ia['contactno']; ?>">
														    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review">test1</button>
														    <span id="valid-msg" class="hide" style="color:#67cc19">✓ Valid</span>
															<span id="error-msg" class="hide" style="color:#ea0909"></span>
														    <div id="phone_codes"></div>
														    <div id="error_four" style="margin-top: 8px;"></div>
														</div><span id="phone_err" class="invalidText"></td>
													</tr>
													<tr>
														
														<th>Country</th>
														<td><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="country" id="country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ia['country']){ echo "selected"; } ?>><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div><span id="country_err" class="invalidText"></span></td>
														<th>Profile Picture</th>
														<td><div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h">
														</div></td>
													</tr>
													<tr>
														
														<th>CTO Profile Picture</th>
														<td><div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="cto_profilepicture" id="cto_profilepicture" class="form-control imgInput" type="file">
															<input type="hidden" name="cto_profilepicture_h" id="cto_profilepicture_h">
														</div></td>
													</tr>
												</tbody>
											</table>
										</div>

										<div class="row">
											<div class="col-md-6">
												<button type="submit">Submit</button>
											</div>
										</div>
										
										<?php echo form_close(); ?>


										<div class="noteDetail">
											<div class="panel panel-default">
												<div class="panel-heading"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
												<div class="panel-body">
													<div class="detailTebler filterTable table-responsive">
														<table id="example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>User</th>
																	<th>Name</th>
																	<th>Description</th>
																	<th>Date</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Loading..</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>


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
	<?php $this->load->view('include/footer.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>
	 <?php $this->load->view('include/confim_popup.php'); ?>
	<script>
	function loadTableData(){
            var url = "<?php echo site_url() ?>licensee/Licensee/viewnote";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "searching": false,
            } );
        };
	loadTableData();
    </script>
</div>
<!-- Modal -->
<div id="addNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
		<div class="addNote">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Add Note</h3>
		<?php echo form_open('licensee/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title" class="form-control" placeholder="Title" required="true" value="" type="text">
						<span id="app_activity_title_err" class="invalidText"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="app_activity_des"></textarea>
					</div>
				</div>
				<div class="addButton">
					<button>Submit</button>
					<button class="cenle" data-dismiss="modal">Cancel</button>
				</div>
			<?php echo form_close(); ?>
		</div>
    </div>

  </div>
</div>
</body>
</html>