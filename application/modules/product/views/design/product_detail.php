<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ethical</title>
	<?php include'head.php'; ?>
</head>
<body>
<div id="wrapper">
	<?php include'header.php'; ?>
	<article>
		<content>
			<main>
				<div class="dashSection">
					<div class="dashCard">
						<div class="dashNav">
							<?php include'nav.php'; ?>
						</div>
						<div class="dashBody">
							<div class="innerDiv">
								<div class="aside">
									<h3>Shop</h3>
									<form class="shopForm">
										<input type="text" name="" class="form-control" placeholder="search...">
									</form>
									<ul>
										<li>
											<a href="#">All Products</a>										</li>
										<li>
											<a href="#">Shop by Category</a>
											<ul>
												<li>
													<a href="#" class="active">Audits</a>
												</li>
												<li>
													<a href="#">Packaging</a>
												</li>
												<li>
													<a href="#">Office Suppliers</a>
												</li>
												<li>
													<a href="#">Furniture</a>
												</li>
												<li>
													<a href="#">Clothing</a>
												</li>
											</ul>
										</li>
									</ul>
									<div class="sortBy">
										<form class="shopForm">
											<label>Sort by</label>
											<select class="form-control">
												<option>Please Select</option>
												<option>Most Popular</option>
											</select>
										</form>
									</div>
								</div>
								<div class="filterBody">
									<div class="filterDiv">
										<div class="producDetl">
											<div class="row">
												<div class="col-md-4">
													<div class="proImg">
														<img src="assets/img/produc.png" alt="Product">
													</div>
												</div>
												<div class="col-md-8">
													<a href="#" class="veiwPro">Back to Shop</a>
													<div class="productDetail proPage">
														<span>Audits</span>
														<h4>Basic Electrical Audit</h4>
														<b>$99.00</b>
														<div class="quality">
															<span>Quantity</span>
															<input type="text" name="" value="1">
															<a href="#" class="addNew">Add to Cart</a>
														</div>
														<p>Lorem ipsum dolor sit amet</p>
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
														tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
														quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
														consequat.</p>
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
														tempor incididunt ut labore et dolore magna aliqua.</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="bannerDiv">
										<img src="assets/img/asss_banner.png" alt="Ads" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</content>
	</article>
	<?php include'footer.php' ?>
</div>
</body>
</html>