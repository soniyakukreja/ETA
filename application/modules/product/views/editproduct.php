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
										<h3>Edit Product</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_product','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $product['prod_id']; ?>">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Product Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="<?php echo $product['product_name']; ?>" type="text"></div>
														<span id="product_name_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Product SKU</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="product_sku" id="product_sku" class="form-control" placeholder="Product SKU"  value="<?php echo $product['product_sku']; ?>" type="text" maxlength="70" minlength="2"></div>
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
																	 <option value="<?php echo $value['prod_cat_id']; ?>" <?php if ($value['prod_cat_id']==$product['prod_cat_id']) { echo "selected";} ?>><?php echo $value['prod_cat_name']; ?>
																	 	
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
																	 <option value="<?php echo $value['supplier_id']; ?>" <?php if ($value['supplier_id']==$product['supplier_id']) { echo "selected";} ?>><?php echo $value['supplier_fname']; ?>
																	 	
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
															  <option value="Standard" <?php if ($product['type']=="Standard") { echo "selected";} ?>>Standard</option>
															  <option value="Audit" <?php if ($product['type']=="Audit") { echo "selected";} ?>>Audit</option>
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
															<input  name="wsale_price" id="wsale_price" class="form-control" type="text" value="<?php echo $product['wsale_price']; ?>">
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
															<input  name="l_price" id="l_price" class="form-control" value="<?php echo $product['l_price']; ?>" type="text" placeholder="Licensee Price">
														</div>
														<span id="l_price_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group required">
														<label>Industry Association Price</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="ia_price" id="ia_price" class="form-control" value="<?php echo $product['ia_price']; ?>" type="text" placeholder="Industry Association Price">
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
															<input  name="c_price" id="c_price" class="form-control" value="<?php echo $product['c_price']; ?>" type="text" placeholder="Consumer Price">
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
													<div class="form-group">
														<label>Discount</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
															<input  name="prod_dis" id="prod_dis" class="form-control" value="<?php echo $product['prod_dis']; ?>" type="text" placeholder="Discount">
														</div>
														<span id="prod_dis_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Discount Start Date</label>
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input  name="prod_dis_startdate" id="prod_dis_startdate" class="form-control datepicker_from" <?php if($product['prod_dis_startdate'] != ''){echo 'value='. date('m/d/Y', strtotime($product['prod_dis_startdate']));} ?> type="text" onkeydown="event.preventDefault()" placeholder="Discount Start Date">
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
															<input  name="prod_dis_enddate" id="prod_dis_enddate" class="form-control datepicker_from" <?php if($product['prod_dis_enddate'] != ''){echo 'value='. date('m/d/Y', strtotime($product['prod_dis_enddate']));} ?>  type="text" onkeydown="event.preventDefault()" placeholder="Discount End Date">
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
																	 <option value="<?php echo $value['urole_id']; ?>" <?php if($value['urole_id']==$product['urole_id']){ echo "selected";} ?>><?php echo $value['rolename']; ?></option>
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
																<option>Please Select</option>
															  <option value="1" <?php if ($product['prod_status']=="1") { echo "selected";} ?>>Active</option>
															  <option value="0" <?php if ($product['prod_status']=="0") { echo "selected";} ?>>Inactive</option>
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
															  <option value="<?php echo $temp['frm_manager_id']; ?>" <?php if($temp['frm_manager_id']==$product['ck_form_id']){echo "selected";} ?>><?php echo str_replace('_',' ',$temp['frm_template_name']); ?></option>
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
																
																<textarea class="form-control xs ta-xt ckeditor" name="prod_description" ><?php echo $product['prod_description']; ?></textarea>
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
<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>