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
										<h3>Product</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
											<?php echo form_open('',array('class'=>'addForm','id'=>'add_product','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Product Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="" type="text"></div>
														<span id="product_name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Product SKU</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="product_sku" id="product_sku" class="form-control" placeholder="Product SKU"  value="" type="text" maxlength="70" minlength="8"></div>
														<span id="product_sku_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="prod_cat_id" id="prod_cat_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['prod_cat_id']; ?>"><?php echo $value['prod_cat_name']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="prod_cat_id_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Supplier</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
															<select class="form-control js-example-basic-single" name="supplier_id" id="supplier_id">
																<option value="">Please Select</option>
																<?php if (isset($supplier)) {
																	foreach ($supplier as $value) { ?>
																	 <option value="<?php echo $value['supplier_id']; ?>"><?php echo $value['supplier_fname']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="supplier_id_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Type</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-text-height"></i></span>
															<select class="form-control js-example-basic-single" name="type" id="type">
																<option value="">Please Select</option>
															  <option value="Standard">Standard</option>
															  <option value="Audit">Audit</option>
															</select>
														</div>
														<span id="type_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Wholesale Price</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
															<input  name="wsale_price" id="wsale_price" class="form-control"  type="text" placeholder="Wholesale Price">
														</div>
														<span id="wsale_price_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Licensee Price</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="l_price" id="l_price" class="form-control"  value="" type="text" placeholder="Licensee Price">
														</div>
														<span id="l_price_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Industry Association Price</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="ia_price" id="ia_price" class="form-control"  value="" type="text" placeholder="Industry Association Price">
														</div>
														<span id="ia_price_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Consumer Price</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="c_price" id="c_price" class="form-control" value="" type="text" placeholder="Consumer Price">
														</div>
														<span id="c_price_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Product Image</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="productimg" id="productimg" class="form-control imgInput" type="file" accept=".jpeg, .jpg, .PNG, .png">
															<input type="hidden" name="productimg_h" id="productimg_h">
														</div>
														<span id="product_name_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group ">
														<label>Discount (%)</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input name="prod_dis" id="prod_dis" class="form-control" value="" type="text" placeholder="Discount">
														</div>
														<span id="prod_dis_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Discount Start Date</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input  name="prod_dis_startdate" id="prod_dis_startdate" class="form-control datepicker_from"  value="" type="text" placeholder="Discount Start Date" onkeydown="event.preventDefault()">
														</div>
														<span id="prod_dis_startdate_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Discount End Date</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input  name="prod_dis_enddate" id="prod_dis_enddate" class="form-control datepicker_from"  value="" type="text" placeholder="Discount End Date" onkeydown="event.preventDefault()">
														</div>
														<span id="prod_dis_enddate_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<!-- <div class="form-group required">
														<label>Intended Type</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>

															<select class="form-control js-example-basic-single" name="role_id" id="role_id">
																<option value="">Please Select</option>
																<?php if (isset($type)) {
																	foreach ($type as $value) { ?>
																	 <option value="<?php echo $value['urole_id']; ?>"><?php echo $value['rolename']; ?></option>
																<?php 	}
																} ?>
														
															</select>
														</div>
														<span id="role_id_err" class="invalidText"></span>

													</div> -->
												</div>
												
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Status</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="prod_status" id="prod_status">
																<option value="">Please Select</option>
															  <option value="1">Active</option>
															  <option value="0">Inactive</option>
															</select>
														</div>
														<span id="prod_status_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Select Checkout Form</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<select class="form-control js-example-basic-single" name="ck_form_id" id="ck_form_id">
															  <option value="">Please Select</option>
															  <?php if(!empty($form_templates)){ foreach($form_templates as $temp){ ?>
															  <option value="<?php echo $temp['frm_manager_id']; ?>"><?php echo str_replace('_',' ',$temp['frm_template_name']); ?></option>
															  <?php } } ?>
															</select>
														</div>
														<span id="ck_form_id_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-12">
													<div class="form-group">
														<label>Description</label>
														<div>
															
															<textarea class="form-control xs ta-xt ckeditor" name="prod_description" placeholder="Enter Description"></textarea>
														</div>
														
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
	<?php $this->load->view('include/crop_image_modal'); ?>	
<?php $this->load->view('include/footer'); ?>
</div>
</body>
</html>