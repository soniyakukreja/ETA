	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashBody">
							<div class="innerDiv">
								<div class="cartDetail">
									<div class="filterBody">
										<div class="filterDiv">
											<div id="addressDiv" class="divsec">
												<div class="col-md-4">
													<div class="bilDetail">
														<div id="successMsg" class="alert alert-success show">
														  <strong>Thank you for shopping with us</strong>
														</div>
													</div>
												</div>
												<div class="col-md-8">
												<div class="bilDetail">
													<h3>Your Order Summary</h3>
													<div class="cartTable">
														<table>
															<tbody>
																<?php $carttotal = 0;
																
																if(!empty($order_detail)){ 
																	
																foreach($order_detail as $product){  ?>
																<tr>
																	<td>
																		<h4><?php echo $product['prod_name']; ?></h4>
																		<!-- <span><?php echo $product['product_sku']; ?></span> -->
																	</td>
																	<td>
																		<?php $prodtotal = $product['prod_price']*$product['prod_qty']; ?>
																		<b><?php echo $product['prod_qty']; ?> x <?php echo numfmt_format_currency($this->fmt,$product['prod_price'], "USD"); ?></b>
																	</td>
																</tr>
																<?php $carttotal += $prodtotal; 
																 }}  ?>
															</tbody>
														</table>
													</div>
													<div class="totalCart">
														<p>Total Amount <?php echo numfmt_format_currency($this->fmt,$carttotal, "USD"); ?></p>
													</div>
												</div>
											</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
</div>
</body>
</html>

