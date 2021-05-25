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
							<?php $this->load->view('shop/shop_leftbar'); ?>
							<div class="filterBody">
								<div class="filterDiv"> 
									<div id="errorMsg" class="alert alert-danger hide">
                  					Payment Canceled
                					</div>
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
<?php $this->load->view('include/footer'); ?>
</div>
</body>
</html>