<?php $this->load->view('include/header.php'); ?>
<style>
	#example_filter {
	 margin:  0px;
	}
</style>
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
	<?php $this->load->view('include/footer.php'); ?>

	<script>
		function loadTableData(){
            var url = "<?php echo site_url();?>consumer/ajax_orederhistory";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "order": [[1, "desc" ]],
            } );
        };
		loadTableData();
    </script>
</div>
</body>
</html>