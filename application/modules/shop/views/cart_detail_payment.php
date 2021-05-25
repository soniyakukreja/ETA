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
								<div class="cartDetail">
									<div class="filterBody">
										<div class="filterDiv">
											<div class="row">
												<div class="col-md-4">
													<div class="bilDetail">
														<h3>Payment</h3>
														<form class="billingForm">
															<div class="form-group">
																<label>Name *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your name">
															</div>
															<div class="form-group">
																<label>Card Number *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your credit card number">
															</div>
															<div class="form-group">
																<label>Expiration Date *</label>
																<div class="row">
																	<div class="col-md-3">
																		<select class="form-control">
																			<option>MM</option>
																			<option>1</option>
																			<option>2</option>
																			<option>3</option>
																		</select>
																	</div>
																	<div class="col-md-3">
																		<select class="form-control">
																			<option>YY</option>
																			<option>2020</option>
																			<option>2021</option>
																			<option>2022</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label>CCV *</label>
																<input type="text" name="" class="form-control" placeholder="Enter your CCV">
															</div>
															<div class="payBtn form-group">
																<button class="addNew" href="#">Confirm Order</button>
															</div>

															<div class="payBtn">
																<a class="veiwPro" href="#">Back to Additional Questions</a>
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
										<?php $this->load->view('include/rightsidebar.php'); ?>
									</div>
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