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
								<?php $dep= $this->generalmodel->getSingleRowById('department','dept_id', $ia['dept_id'], $returnType = 'array'); 
									  $Country= $this->generalmodel->getSingleRowById('country','id', $ia['country'], $returnType = 'array');
								 ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Edit Industry Associations</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>

											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_ia','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($ia['ia_profilepicture'])){ echo base_url('uploads/ia_profile/').$ia['ia_profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="profilepicture" id="profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png">
															<input type="hidden" name="profilepicture_h" id="profilepicture_h" class="hiddenfile" preview="true">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="" class="invalidText image_err"></span>
													</div>
												</div>											
											</div><br>
											<input type="hidden" id="iaid" name="id" value="<?php echo $ia['ia_id']; ?>">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Industry Association Licence Number</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
															<input  name="lic_number" id="lic_number" placeholder="Industry Association Licence Number" class="form-control" type="text" value="<?php echo $ia['ia_lic_number']; ?>">
														</div>
														<span id="lic_number_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group required">
																<label>Industry Association Licence Start Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_startdate" id="lic_startdate" class="form-control datepicker_from" type="text" value="<?php echo date('m/d/Y', strtotime($ia['ia_lic_startdate']));?>" onkeydown="event.preventDefault()">
																</div>
																<span id="lic_startdate_err" class="invalidText"></span>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group required">
																<label>Industry Association Licence End Date</label>
																<div class="dateInput"><span class="input-group-addon">
																	<i class="glyphicon glyphicon-calendar"></i></span>
																	<input name="lic_enddate" id="lic_enddate" class="form-control endDate_edit datepicker_to" type="text" value="<?php echo date('m/d/Y', strtotime($ia['ia_lic_enddate']));?>" onkeydown="event.preventDefault()">
																</div>
																<span id="lic_enddate_err" class="invalidText"></span>
															</div>
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
																<option value="<?php echo $value['user_id']; ?>" <?php if($value['user_id']==$ia['assign_to']){ echo 'selected'; } ?> ><?php echo $value['username']; ?></option>
															  <?php } } ?>
															</select>
														</div>	
														<span id="assign_to_err" class="invalidText"></span>												
													</div>													
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Award Levels</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="category" id="category"  autocomplete="off" >
															  <option value="">Please Select</option>
															  <?php if(!empty($categorylist)){  foreach($categorylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ia['category']){ echo 'selected'; } ?> ><?php echo $value['name']; ?></option>
															  <?php } } ?>
															</select>
														</div>													
													</div>
												</div>
											</div>															
											<hr>
											<div class="row"><div class="col-md-6"><p class="toAdd">CTO Detail</p></div></div>										
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($ia['profilepicture'])){ echo base_url('uploads/cto_profile/').$ia['profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>CTO Profile Picture</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-file"></i></span>
															<input  name="cto_profilepicture" id="cto_profilepicture" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png">
															<input type="hidden" name="cto_profilepicture_h" id="cto_profilepicture_h" class="hiddenfile" preview="true">
															<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="" class="invalidText image_err"></span>
													</div>
													<div class="form-group required">
														<label>Country</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="ia_country" id="ia_country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($ia['country']==$value['id']){ echo 'selected'; } ?> ><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="ia_country_err" class="invalidText"></span>
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
															<input  name="firstname" id="firstname" class="form-control" placeholder="CTO First Name" type="text" value="<?php echo $ia['firstname']; ?>">
														</div>
														<span id="firstname_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Last Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<input  name="lastname" id="lastname" class="form-control" placeholder="CTO Last Name" type="text" value="<?php echo $ia['lastname']; ?>">
														</div>
														<span id="lastname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>CTO Email Address</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input  name="email" id="email" class="form-control" value="<?php echo $ia['email']; ?>" type="email" placeholder="CTO Email Address">
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

												</div>
											</div>	
											<?php /*										
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Role</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input name="dept" id="dept" class="form-control" value="CTO" type="text" placeholder="Role" onkeydown="event.preventDefault()" readonly>
														</div>
														<span id="dept_err" class="invalidText"></span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Category</label>
														<div class="dateInput"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="category" id="category"  autocomplete="off" >
															  <option value="">Please Select</option>
															  <?php if(!empty($categorylist)){  foreach($categorylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ia['category']){ echo 'selected'; } ?> ><?php echo $value['name']; ?></option>
															  <?php } } ?>
															</select>
														</div>													
													</div>
												</div>
												<div class="col-md-6"></div>
											</div>
											*/ ?>	
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
														<span id="cp_err" class="invalidText" style="display:none;"></span>
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
															<input name="business_name" id="ia_business" class="form-control" placeholder="Business Name" autocomplete="off" value="<?php echo $ia['business_name']; ?>" type="text" readonly>
															<input type="hidden" name="business_id" id="business_id" value="<?php echo $ia['business_id']; ?>" >
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
															<div class="input-group">
																<!-- <textarea name="address" id="address" cols="50" row="2"></textarea> -->
																<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
																<input name="address" id="address" class="form-control" placeholder="Address"type="text" value="<?php echo $ia['business_street1']; ?>">
															</div>
															<span id="address_err" class="invalidText"></span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group required">
															<label>Suburb/Province</label>
															<div class="input-group">
																<!-- <textarea name="suburb" id="suburb" cols="50" row="2"></textarea> -->
																<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
																<input name="suburb" id="suburb" class="form-control" placeholder="Suburb/Province" type="text" value="<?php echo $ia['business_suburb']; ?>">
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
																	<option value="<?php echo $value['id']; ?>" <?php if($ia['business_country']==$value['id']){ echo 'selected'; } ?> ><?php echo $value['country_name']; ?></option>
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
																	<td>Loading....</td>
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
	<input type="hidden" id="ia_id" value="<?php echo $ia['ia_id']; ?>" >
	<?php $this->load->view('include/crop_image_modal'); ?>	
	<?php $this->load->view('include/footer.php'); ?>
	<?php $this->load->view('industryassociation/ia_js.php'); ?>
	<?php $this->load->view('include/readmore_modal.php'); ?>
	 <script type="text/javascript" charset="utf-8">
        function loadTableData() {
            var url = "<?php echo site_url() ?>industryassociation/Industryassociation/viewnote";
         	var ia_id = $('#ia_id').val();

            $('#example').dataTable( {
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'ia_id':ia_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        }
        loadTableData();

        function loadData() {
            var url = "<?php echo site_url() ?>industryassociation/Industryassociation/viewnote";
         	var ia_id = $('#ia_id').val();

            $('#example').dataTable( {
            	"destroy":true,
                "serverSide": true,
                "ajax": {
			          "url": url,
			          "type": "POST",
			          "data":{'ia_id':ia_id},
			        },
                "searching": false,
                "aaSorting": [[3, 'desc']],
            } );
        }
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
		<?php echo form_open('industryassociation/addnote',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="ia_id" value="<?php echo $ia['ia_id']; ?>" >
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