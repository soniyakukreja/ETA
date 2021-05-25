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
								<div class="cartDetail">
									<div class="filterBody">
										<div class="filterDiv">
											<div class="row">
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Additional Questions</h3>
														<h5>Product Name</h5>
														<form class="billingForm">
															<div class="form-group">
																<label>Name *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your name">
															</div>
															<div class="form-group">
																<label>Email Address *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your email aAddress">
															</div>
															<div class="form-group">
																<label>Phone Number *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your best contact number">
															</div>
															<h5>Product Name</h5>
															<div class="form-group">
																<label>Street Address *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your street address">
															</div>
															<div class="form-group">
																<label>Street Address</label>
																<input type="text" name="" class="form-control" placeholder="Enter your street address">
															</div>
															<div class="form-group">
																<label>Suburb *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your suburb">
															</div>
															<div class="form-group">
																<label>State/Region</label>
																<input type="text" name="" class="form-control" placeholder="Enter your State or Region">
															</div>
															<div class="payBtn form-group">
																<a class="addNew" href="#">Go to Payment</a>
															</div>

															<div class="payBtn">
																<a class="veiwPro" href="#">Back to Billing/Shipping Details</a>
															</div>
														</form>
													</div>
												</div>
												<div class="col-md-4"></div>
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Your Cart</h3>
														<div class="cartTable">
															<table>
																<tbody>
																	<tr>
																		<td>
																			<h4>Basic Electronic Audit</h4>
																			<span>Audit</span>
																		</td>
																		<td>
																			<b>1 x $99.00</b>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h4>Basic Electronic Audit</h4>
																			<span>Audit</span>
																		</td>
																		<td>
																			<b>1 x $99.00</b>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h4>Basic Electronic Audit</h4>
																			<span>Audit</span>
																		</td>
																		<td>
																			<b>1 x $99.00</b>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<h4>Basic Electronic Audit</h4>
																			<span>Audit</span>
																		</td>
																		<td>
																			<b>1 x $99.00</b>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
														<div class="totalCart">
															<p>Cart Total $495.00</p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php $this->load->view('include/rightsidebar'); ?>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<?php $this->load->view('include/footer'); ?>
</div>
</body>
</html>