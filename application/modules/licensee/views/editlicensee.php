<?php $this->load->view('include/header'); ?>
<style>
	.addNew {
		position: unset;
	}
</style>
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
										<h3>Licensee Details</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<?php //echo "<pre>"; print_r($ia); exit; ?>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_licensee','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<input type="hidden" name="id" value="<?php echo $ia['lic_id']; ?>">

											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($ia['lic_profilepicture'])){ echo base_url('uploads/licensee_profile/').$ia['lic_profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Licensee Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="lic_profilepicture" id="lic_profilepicture" class="form-control imgInput" type="file" accept=".jpeg,.JPEG,.jpg,.JPG,.PNG,.png" is_valid="1">
															<input type="hidden" name="lic_profilepicture_h" id="lic_profilepicture_h" class="hiddenfile" preview="true">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="lic_profile_err" class="invalidText image_err"></span>
													</div>
												</div>												
											</div>
											<br>											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>License Number</label>
														<div class="input-group"><span class="input-group-addon"> 
															<i class="glyphicon glyphicon-book"></i></span>
															<input  name="lic_number" id="lic_number" placeholder="License Number" class="form-control" value="<?php echo $ia['lic_number']; ?>" type="text" autocomplete="off">
														</div>
														<span id="lic_number_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group required">
																	<label>License Start Date</label>
																	<div class="dateInput"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-calendar"></i></span>
																		<input name="lic_startdate" id="lic_startdate" class="form-control datepicker_from" type="text" onkeydown="event.preventDefault()" value="<?php echo date('m/d/Y', strtotime($ia['lic_startdate']))?>" >
																	</div>
																	<span id="lic_startdate_err" class="invalidText"></span>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group required">
																	<label>License End Date</label>
																	<div class="dateInput"><span class="input-group-addon">
																		<i class="glyphicon glyphicon-calendar"></i></span>
																		<input name="lic_enddate" id="lic_enddate" class="form-control endDate_edit datepicker_to" type="text" onkeydown="event.preventDefault()" value="<?php echo date('m/d/Y', strtotime($ia['lic_enddate']))?>">
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
														<label>License File</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="license_file" id="license_file" class="form-control pdffile" value="" type="file" accept=".pdf" is_valid="1">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported File is PDF</label>
														<br><span id="lic_file_err" class="invalidText pdferror"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Award Level</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="category" id="category">
															  <option value="">Please Select</option>
															  <?php if(!empty($categorylist)){  foreach($categorylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($ia['category'] ==$value['id'] ){ echo 'selected'; } ?>><?php echo $value['name']; ?></option>
															  <?php } } ?>
															</select>
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
																<option value="<?php echo $value['user_id']; ?>" <?php if($value['user_id']==$ia['assign_to']){ echo 'selected';} ?> ><?php echo $value['username']; ?></option>
															  <?php } } ?>
															</select>
														</div>	
														<span id="assign_to_err" class="invalidText"></span>												
													</div>													
												</div>
											</div>

											<hr>
											<div class="row">
												<div class="col-md-6"><p class="toAdd">CTO Detail</p></div>
											</div>		
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($ia['profilepicture'])){ echo base_url('uploads/cto_profile/').$ia['profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>CTO Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg,.JPEG,.jpg,.JPG,.PNG,.png" is_valid="1">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h" class="hiddenfile" preview="true">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="cto_profile_err" class="invalidText image_err"></span>
													</div>
													<div class="form-group required">
														<label>Country</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="l_country" id="l_country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ia['l_country']){ echo "selected"; } ?>><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="l_country_err" class="invalidText"></span>
													</div>													
												</div>												
											</div>
											<br>			

											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO First Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="firstname" id="firstname" class="form-control" placeholder="CTO First Name" value="<?php echo $ia['firstname']; ?>" type="text">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Last Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="lastname" id="lastname" class="form-control" placeholder="CTO Last Name" value="<?php echo $ia['lastname']; ?>" type="text">
														</div>
														<span id="lastname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<?php /*
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group">
														<label>CTO Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg,.JPEG,.jpg,.JPG,.PNG,.png" is_valid="1">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h" class="hiddenfile">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="cto_profile_err" class="invalidText image_err"></span>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Country</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="l_country" id="l_country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ia['l_country']){ echo "selected"; } ?>><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="l_country_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											*/ ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Email Address</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" uid="<?php echo $ia['user_id']; ?>" class="form-control"  value="<?php echo $ia['email']; ?>" type="email" placeholder="CTO Email Address">
														</div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Contact Number</label>
														<div class="inputGroup">
															<input type="text" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $ia['contactno']; ?>">
														    <button type="button" class="hide" id="sa-warning" class="btn btn-primary" data-toggle="modal" data-target="#login_for_review"></button>
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
													<div class="form-group">
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
													<div class="form-group">
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
														<span id="cp_err" class="invalidText"  style="display:none;"></span>
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
														            <option value="<?php echo $row; ?>" <?php if($ia['timezone']==$row){ echo "selected";} ?>><?php echo $row; ?>
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
															<input name="business_name" id="licensee_business" class="form-control" placeholder="Business Name" autocomplete="off" value="<?php echo $ia['business_name']; ?>" type="text" busid="<?php echo $ia['business_id']; ?>" readonly >
															<input type="hidden" name="business_id" id="business_id" value="<?php echo $ia['business_id']; ?>">
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="busContainer">
															</ul>
														</div>														
														<span id="business_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div id="businessStDiv" style="display:block;">
														<div class="form-group required">
															<label>State/Region</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input name="state" id="state" class="form-control" type="text" value="<?php echo $ia['business_state']; ?>" placeholder="State">
															</div>
															<span id="state" class="invalidText"></span>
														</div>
													</div>
												</div>
											</div>
											<div id="businessDiv" style="display:block;">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input name="address" id="address" class="form-control" placeholder="Street Address" autocomplete="off" value="<?php echo $ia['business_street1']; ?>" type="text">
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb/Province</label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-road"></i></span>
																<input name="suburb" id="suburb" class="form-control" placeholder="Suburb/Province" autocomplete="off" value="<?php echo $ia['business_suburb']; ?>" type="text">
															</div>
															<span id="suburb_err" class="invalidText"></span>
														</div>
													</div>
												</div>

												<!-- <div class="row">
													<div class="col-md-6">
														<div class="form-group required">
															<label>Street Address</label>
															<div class="input-group">
																<textarea name="address" id="address" cols="50" row="2"></textarea>
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb</label>
															<div class="input-group">
																<textarea name="suburb" id="suburb" cols="50" row="2"></textarea>
															</div>
															<span id="suburb_err" class="invalidText"></span>
														</div>
													</div>
												</div> -->
												<div class="row">												
													<div class="col-md-6">
														<div class="form-group required">
															<label>Postcode </label>
															<div class="input-group"><span class="input-group-addon">
																<i class="glyphicon glyphicon-user"></i></span>
																<input name="postcode" id="postcode" class="form-control" placeholder="Postcode"type="text" value="<?php echo $ia['business_postalcode']; ?>">
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
																	<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $ia['business_country']){ echo 'selected'; } ?> ><?php echo $value['country_name']; ?></option>
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
																	<!-- <th>Name</th> -->
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
									<?php $this->load->view('include/rightsidebar'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<input type="hidden" id="lic_id" value="<?php echo $ia['lic_id']; ?>" >
	<?php $this->load->view('include/crop_image_modal'); ?>	
	<?php $this->load->view('include/footer'); ?>
	<?php $this->load->view('licensee/licensee_js'); ?>
	<?php $this->load->view('include/readmore_modal'); ?>
	 <?php $this->load->view('include/confim_popup'); ?>
	<script>
	function loadTableData(){
            var url = "<?php echo site_url() ?>licensee/Licensee/viewnote";
          	var lic_id = $('#lic_id').val();
            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'lic_id':lic_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
	loadTableData();
	function loadData(){
            var url = "<?php echo site_url() ?>licensee/Licensee/viewnote";
          	var lic_id = $('#lic_id').val();
            $('#example').dataTable( {
            	"destroy": true,
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'lic_id':lic_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        };
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
				<input type="hidden" id="lic_id" name="lic_id" value="<?php echo $ia['lic_id']; ?>" >
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title" id="app_activity_title" class="form-control" placeholder="Title"  value="" type="text">
					</div>
						<span id="app_activity_title_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="app_activity_des" id="app_activity_des"></textarea>
					</div>
					<span id="app_activity_des_err" class="invalidText"></span>
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
<style type="text/css">
.modal-dialog {
    width: 600px;
    margin: 138px auto;
}
</style>
</body>
</html>