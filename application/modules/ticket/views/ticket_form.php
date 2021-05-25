<?php $this->load->view('include/header.php'); ?>
<style type="text/css">
	
.form-group  .btn-group button {
    background: none;
    border: 1px solid #ccc;
    display: block;
    margin-left: 0px;
    box-shadow: none;
    width: 100%;
    border-radius: 0px; 
}
.multiselect-container>li>a>label {
    line-height: 20px;
}
.form-group .btn-group button:hover {
	background: none;
}
.btn-group.open .dropdown-toggle {
	box-shadow: none;
}
.open>.dropdown-toggle.btn-default {
	background: none !important;
	 border: 1px solid #ccc !important;
	
}
.input-group .btn-group {
    display: block;
}

span.multiselect-selected-text {
    float: left;
}

.dropdown-menu>.active>a{
background: none;
}
b.caret {
    position: absolute;
    right: 8px;
    top: 50%;
}

ul.multiselect-container.dropdown-menu {
    width: 100%;
    height: 250px;
    left: 0;
    margin-top: 33px;
    box-shadow: none;
    overflow-y: auto;
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
									<div class="filterDiv">
										<h3>Add Ticket</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          					<strong>Warning!</strong>
                                       						</div>
                                        					<div id="successMsg" class="alert alert-success hide">
                                          					<strong>Success!</strong>
                                        					</div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'add_ticket','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Title</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_title" id="tic_title" class="form-control" placeholder="Ticket Title"  value="" type="text"></div>
														<span id="tic_title_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control selectpicker ticuser" name="tic_users[]" id="tic_user" multiple>
															  
															
																<?php if (isset($user)) {
																	foreach ($user as $value) { 
														$buss = $this->generalmodel->getparticularData("business_name",'business',"business_id=".$value['user_id'],"row_array");
																		if($value['urole_id']==1){
																			$st = "(ETA Global)";
																		}else{
																			$st = "(LC Consultants)";
																		}
																		?>
																	 <option value="<?php echo $value['user_id']; ?>"><?php echo $value['firstname'].' '.$value['lastname'].' ('.$buss['business_name'].') '.$st; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															</select>
														</div>
														<span id="tic_users_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="tic_cat_id" id="tic_cat_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['tic_cat_id']; ?>"><?php echo $value['tic_cat_name']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="tic_cat_id_err" class="invalidText"></span>
													</div>
												</div>
												<?php /*
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="tic_status" id="tic_status">
																<option value="">Please Select</option>
																<option value="0">Open</option>
																<option value="1">Pending</option>
																<option value="2">Resolved</option>
																<option value="3">Spam</option>
																
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="tic_status_err" class="invalidText"></span>
													</div>
												</div>*/ ?>
												
											</div>
											<div class="row">
												<div class="col-md-12">
													<!-- <div class="form-group">
 													<textarea  class="form-control xs ta-xt ckeditor" name="tic_desc" id="tic_desc" placeholder="Enter Ticket Description *" ></textarea>
													</div>
													<span id="content_err" class="invalidText"></span> -->
												<div class="form-group">
													<label>Description</label>
													<div class="input-group">
														<span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i>
														</span>
														<textarea cols="5" rows="5" class="desript" id="tic_desc" name="tic_desc"></textarea>
													</div>
													<span id="tic_desc_err" class="invalidText"></span>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script>
      $(document).ready(function() {
        $('#tic_user').multiselect({
          includeSelectAllOption: true,
        });
    });
</script>

</div>
</body>
</html>