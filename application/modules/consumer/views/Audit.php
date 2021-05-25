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
										<h3><?php echo $page_heading; ?></h3>
										<div class="filterTable exportButton">
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
													<th>Order Numer</th>
													<th>Order Date</th>
													<th>Order Total</th>
													<th>Actions</th>
										            </tr>
										        </thead>
										        <tbody>
										            <tr>
										            	<td>Loading....</td>
										            </tr>
										        </tbody>
										    </table>
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

	<script>
		function loadTableData(){
            var url = site_url+"Audit/ajax_audit";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
            } );
        };
		loadTableData();
    </script>
</div>
</body>
</html>