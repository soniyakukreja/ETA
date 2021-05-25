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
										<h3>Add Ticket Category </h3>
										<div id="errorMsg" class="alert alert-danger hide"></div>
                                        <div id="successMsg" class="alert alert-success hide"></div>

										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'add_ticcategory','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Category Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_cat_name" id="tic_cat_name" class="form-control" placeholder="Category Name" value="" type="text"></div><span id="cat_name_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Parent Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>

															<select class="form-control js-example-basic-single" name="tic_parent_id" id="tic_parent_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['tic_cat_id']; ?>"><?php echo $value['tic_cat_name']; ?></option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
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
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>