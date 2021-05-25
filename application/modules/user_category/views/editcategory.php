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
								
									<?php $this->load->view('include/leftsidebar.php'); ?>
								
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Edit Award Level</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_usercategory','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $cate['user_cat_id']; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<label>Award Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="user_cat_name" id="user_cat_name" class="form-control" placeholder="Category Name" value="<?php echo $cate['user_cat_name']; ?>" type="text"></div>
														<span id="cat_name_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">

												<div class="col-md-6">
													<div class="form-group">
														<label>Intended User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="roles_id" id="roles_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['urole_id']; ?>" <?php if($value['urole_id']==$cate['roles_id']){ echo "selected";} ?>><?php echo $value['rolename']; ?></option>
																<?php 	}
																} ?>
															
															</select>
														</div>
														<span id="roles_id_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Status</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="user_cat_status" id="user_cat_status">
																<option>Please Select</option>
															  <option value="1" <?php if($cate['user_cat_status']==1){echo "selected";} ?>>Active</option>
															  <option value="0" <?php if($cate['user_cat_status']==0){echo "selected";} ?>>Inactive</option>
															</select>
														</div>
														<span id="user_cat_status_err" class="invalidText"></span>
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
									<?php $this->load->view('include/rightsidebar.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>