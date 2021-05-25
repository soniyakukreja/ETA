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
										<h3>Product Category:</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_category','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $cate['prod_cat_id']; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<label>Category Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="prod_cat_name" id="prod_cat_name" class="form-control" placeholder="Category Name" value="<?php echo $cate['prod_cat_name']; ?>" type="text"></div><span id="cat_name_err" class="invalidText">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Parent Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="prod_cat_parent_category_id" id="prod_cat_parent_category_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['prod_cat_id']; ?>"<?php if($value['prod_cat_id']==$cate['prod_cat_parent_category_id']){echo 'selected';} ?>><?php echo $value['prod_cat_name']; ?></option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>

													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Status</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="prod_cat_status" id="prod_cat_status">
																<option>Please Select</option>
															  <option value="1" <?php if($cate['prod_cat_status']==1){echo "selected";} ?>>Active</option>
															  <option value="0" <?php if($cate['prod_cat_status']==0){echo "selected";} ?>>Inactive</option>
															</select>
														</div>
														<span id="user_cat_status_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<!-- <button>Submit</button> -->
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