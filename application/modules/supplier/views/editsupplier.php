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
										<h3>Edit Supplier</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          					<strong>Warning!</strong>
                                        					</div>
                                        					<div id="successMsg" class="alert alert-success hide">
                                          					<strong>Success!</strong>
                                        					</div>
										<?php echo form_open('',array('class'=>'addForm','id'=>'edit_supplier','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											
											<div class="row">
												<div class="col-md-6">
													<img src="<?php if(!empty($sup['profilepicture'])){ echo base_url('uploads/user/').$sup['profilepicture']; }else{ echo base_url('assets/img/avtr.png'); } ?>" class="img" style="width: 200px; height: 200px;">
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Profile Picture</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input  name="supplier_profilepic" id="supplier_profilepic" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png" is_valid="1">
															<input type="hidden" name="supplier_profilepic_h" id="supplier_profilepic_h" class="hiddenfile" preview="true">
														<i class="fa fa-times-circle removeFile" aria-hidden="true"></i>
														</div>
														<label>Only Supported Files are JPG, JPEG, PNG</label>
														<br><span id="ba_image_err" class="invalidText image_err"></span>
													</div>
												</div>
											</div>
											<br>


											<div class="row">
												<input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $sup['supplier_id']; ?>">
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $sup['user_id']; ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>First Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="supplier_fname" id="supplier_fname" class="form-control" placeholder="CTO First Name" required="true" value="<?php echo $sup['supplier_fname']; ?>" type="text"></div>
														<span id="supplier_fname_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Last Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="supplier_lname" id="supplier_lname" class="form-control" placeholder="CTO Last Name" required="true" value="<?php echo $sup['supplier_lname']; ?>" type="text"></div>
														<span id="supplier_lname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Email Address</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input  name="supplier_email" id="supplier_email" class="form-control" required="true" value="<?php echo $sup['email']; ?>" type="email" placeholder="CTO Email Address"></div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Contact Number</label>
														<div class="inputGroup">
															<input type="text" class="form-control" placeholder="Contact number" name="phone" id="phone" autocomplete="off" onkeypress="return isNumberKey(event)" class="inputTel" value="<?php echo $sup['contactno']; ?>">
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
													<div class="form-group">
														<label>Award Level</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="user_cat_id" id="user_cat_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['user_cat_id']; ?>" <?php if ($value['user_cat_id']==$sup['user_cat_id']) { echo 'selected'; } ?>><?php echo $value['user_cat_name']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 	
															  
															</select>
														</div>
															<span id="user_cat_id_err" class="invalidText"></span>

													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group required">
														<label>Country</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="supplier_country" id="supplier_country">
															  <option value="">Please Select</option>
															  <?php if(!empty($countrylist)){  foreach($countrylist as $value){ ?>
																<option value="<?php echo $value['id']; ?>" <?php if($value['id']==$sup['country']){ echo "selected";} ?>><?php echo $value['country_name']; ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="supplier_country_err" class="invalidText"></span>
													</div>
												</div>												
											</div>
											<div class="row">
												<?php /*
												<div class="col-md-6">
													<div class="form-group required">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="business_name" id="business_name" class="form-control" required="true" type="text" placeholder="Business Name" value="<?php echo $sup['supplier_bname']; ?>"></div>
														<span id="business_name_err" class="invalidText"></span>
													</div>
												</div>
												*/ ?>

												<div class="col-md-6">
													<div class="form-group required">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i></span>
															<input name="business_name" id="sup_business" class="form-control" placeholder="Business Name" autocomplete="off" value="<?php echo $sup['supplier_bname']; ?>" type="text">
															<input type="hidden" name="business_id" id="business_id" value="<?php echo $sup['business_id']; ?>">
														</div>
														<div style="position:relative;">
															<ul  style="position:absolute;z-index:111;cursor:pointer;width:100%;" class="list-group" id="busContainer">
															</ul>
														</div>														
														<span id="business_err" class="invalidText"></span>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group required">
														<label>Time Zone</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<?php $OptionsArray = timezone_identifiers_list(); ?>
															 <select select class="form-control js-example-basic-single" name="timezone" id="timezone">
															 	<option value="">Please Select</option>
														      <?php   foreach ($OptionsArray as $key => $row ){ ?>
														            <option value="<?php echo $row; ?>" <?php if($sup['timezone']==$row){ echo "selected";} ?>><?php echo $row; ?>
														            </option>
														        
															<?php } ?>
														        </select>
														</div>
														<span id="timezone_err" class="invalidText"></span>
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
	<?php $this->load->view('include/crop_image_modal'); ?>
	<?php $this->load->view('include/footer.php'); ?>
<script type="text/javascript" src="<?php echo base_url('includes/js/supplier.js'); ?>"></script>

</div>
</body>
</html>