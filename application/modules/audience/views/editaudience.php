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
										<h3>Edit Audience:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_audience','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<label>Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="name" id="name" class="form-control" placeholder="Name"  value="<?php echo $ad['name']; ?>" type="text"></div>
														<span id="name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="businessname" id="businessname" class="form-control" placeholder="Business Name"  value="<?php echo $ad['businessname']; ?>" type="text" maxlength="70" minlength="2"></div>
														<span id="businessname_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Email</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="email" id="email" class="form-control" placeholder="Name"  value="<?php echo $ad['email']; ?>" type="email"></div>
														<span id="email_err" class="invalidText"></span>
													</div>
												</div>
												<!-- <div class="col-md-6">
													<div class="form-group">
														<label>Intended User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="user" id="user">
																<option value="">Please Select</option> -->
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <!-- <option value="<?php echo $value['urole_id']; ?>" <?php if($value['urole_id']==$ad['intended_users']){ echo 'selected';} ?>><?php echo $value['rolename']; ?> -->
																	 	
																	 <!-- </option> -->
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
														<!-- 	</select>
														</div>
														<span id="user_err" class="invalidText"></span>
													</div>
												</div>
											</div>
												
											<div class="row"> -->
												<div class="col-md-6">
													<div class="form-group">
														<label>Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="status" id="status">
																<option value="">Please Select</option>
															  <option value="1" <?php if($ad['status']==1){echo 'selected';} ?>>Active</option>
															  <option value="0" <?php if($ad['status']==0){echo 'selected';} ?>>Inactive</option>
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
							
								

										<div class="row">
											<div class="col-md-6">
												
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
	<?php $this->load->view('include/footer.php'); ?>

<script>
function loadTableData(){
            var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url
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
		<?php echo form_open('ticket/addnote',array('class'=>'addForm','id'=>'add_ticnote','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="id" value="<?php echo $ticket['tic_id']; ?>"> 
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="tic_activity_title" id="tic_activity_title" class="form-control" placeholder="Title" required="true" value="" type="text">
						<span id="tic_activity_title_err" class="invalidText"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Type</label>
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control js-example-basic-single" name="tic_activity_type" id="tic_activity_type">
							<option value="">Please Select</option>
							<option value="All">All</option>
							<option value="Whispers">Whispers</option>
							<option value="Comment">Comment</option>
						</select>
					</div>
					<span id="tic_activity_type_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="tic_activity_des"></textarea>
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