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
								<?php $this->load->view('shop/shop_leftbar',array('prod_cat'=>$prod_cat)); ?>
								<div class="filterBody">
									<div class="filterDiv" id="filterDiv">
										<div class="shopDiv" id="shopDiv"></div>
										<div id="linkdiv"></div>
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
	<?php $this->load->view('include/shop_js'); ?>

<script>

var catid = $('#catid').val();
var sort_by= $('#sort_by :selected').val();
load_products(1,catid,sort_by);

$(document).on('click','.pagination li a', function(e){
	e.preventDefault();
	var page = $(this).data('ci-pagination-page');
	var catid = $(document).find('#catid').val();
	load_products(page,catid);
});

</script>

</div>
</body>
</html>