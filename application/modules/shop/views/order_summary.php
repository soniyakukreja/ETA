<?php 
//echo "<pre>"; print_r($order_detail); exit;
$this->load->view('include/header'); 

$detail = $order_detail['detail'];
$oid = $detail['orders_id'];
$shipsame = $detail['is_billing_same'];
?>
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
											<div id="addressDiv" class="divsec">
												
												<div class="col-md-7">
													<div class="bilDetail">
														<h3>Order Confirmation - #<?php echo $oid; ?></h3>
														<div class="cartTable">
															<table>
																<thead>
																	<tr>
																		<th>Product</th>
																		<th>Price per unit</th>
																		<th>Quantity</th>
																		<th>Discount</th>
																		<th>Total</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $carttotal = 0;
																	
																	if(!empty($order_detail['products'])){ 
																		
																	foreach($order_detail['products'] as $product){  ?>
																	<tr>
																		<td>
																			<?php echo $product['prod_name']; ?>
																			<br>
																			<span><?php echo $product['type']; ?></span>
																		</td>
																		<td><b>
																			<?php echo numfmt_format_currency($this->fmt,$product['prod_price'], "USD"); ?>
																			</b>
																		</td>
																		<td><?php echo $product['prod_qty']; ?></td>
																		<td><?php echo $product['dis_percent'].'%'; ?></td>
																		<td><b>
																			<?php $prodtotal = $product['prod_total']-$product['prod_dis'];
																			echo numfmt_format_currency($this->fmt,$prodtotal, "USD"); ?></b>
																		</td>
																	</tr>
																	<?php $carttotal += $prodtotal; 
																	 }}  ?>
																	<tr>
																		<td colspan="5" class="totalCart" style="text-align:right;">
																		<p>Total Amount <?php echo numfmt_format_currency($this->fmt,$carttotal, "USD"); ?></p>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
														
													</div>
												</div>

												<div class="col-md-5">
												<div class="lnH">	
												<h4>Shipping Details</h4>
												<?php if($detail['is_billing_same']==1){
													echo "Shipping Address is same as billing address<br>";
												}else{
													echo $detail['shipping_address']."<br>";
													echo $detail['shipping_city']."<br>";
													echo $detail['shipping_state']."<br>";
												} ?>
												
												<?php $cdata = getcountry_data($detail['shipping_country']); echo $cdata['country_name']; ?> <br>
												<h4>Billing Details</h4>
												<?php echo $detail['billing_fname'].' '.$detail['billing_lname']; ?> <br>
												<?php echo $detail['billing_email']; ?> <br>
												<?php echo $detail['billing_address']; ?> <br>
												<?php echo $detail['billing_city']; ?> <br>
												<?php echo $detail['billing_state']; ?> <br>
												<?php $cdata = getcountry_data($detail['billing_country']); echo $cdata['country_name']; ?> <br>
												<?php echo $detail['billing_postalcode']; ?> <br>
												
												<!-- <h4>Payment Details</h4> -->
												<?php// echo 'Ending in'.$detail['lastfour']; ?>
												<?php  if(!empty($detail['add_fields'])){ ?>
												<h4>Additional Questions</h4>	
												<?php $add_fields = unserialize($detail['add_fields']); 
													if(!empty($add_fields)){ foreach($add_fields as $key=>$add){
														if($key=='files'){
															foreach($add as $file){
																foreach($file as $k=>$f){
																	$link = base_url('uploads/additional_fields/').$f;
																	if(!empty($f)){
																		echo '<b>'.$k.':</b><a href="'.$link.'" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a>';
																	}else{
																		echo '<b>'.$k.':</b>Not Uploaded</a>';
																	}
																}
															}
														}else{
															foreach($add as $k=>$v){
																echo '<b>'.$k.':</b>';
																if(is_array($v)){ echo $v[0].'<br>'; }else{ echo $v.'<br>'; }
															}
														}
													} }
												?>
												<?php } ?>
												
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
	<?php $this->load->view('include/footer.php'); ?>
</div>
</body>
</html>

