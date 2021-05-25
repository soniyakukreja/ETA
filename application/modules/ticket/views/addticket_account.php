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
								<?php $this->load->view('include/leftsidebar'); ?>
									
								</div>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Add Ticket:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          					<strong>Warning!</strong>
                                       						</div>
                                        					<div id="successMsg" class="alert alert-success hide">
                                          					<strong>Success!</strong>
                                        					</div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'add_ticket_account','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
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
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_users" id="tic_users" class="form-control" placeholder="Ticket Users"  value="" type="text" maxlength="70" minlength="2"></div>
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
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_status" id="tic_status" class="form-control" placeholder="Ticket Status" value="" type="text"></div>
														<span id="tic_status_err" class="invalidText"></span>
													</div>
												</div>
												
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Intended User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="role_id" id="role_id">
																<option value="">Please Select</option>
																<?php if (isset($users)) {
																	foreach ($users as $row) { ?>
																	 <option value="<?php echo $row['urole_id']; ?>"><?php echo $row['rolename']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="role_id_err" class="invalidText"></span>
													</div>
												</div>
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
														<textarea cols="5" rows="5" class="desript" name="tic_desc"></textarea>
													</div>
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