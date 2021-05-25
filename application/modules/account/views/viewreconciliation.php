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
								<div class="aside">
                                <?php $this->load->view('include/leftsidebar.php'); ?>
                                </div>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Reconciliation Report</h3>
                                        
										
										<div class="filterTable exportButton">
											<button class="addNew">Export</button><br><br>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Industry Association Name</th>
										                <th>Consumer Name</th>
										                <th>Supplier Name</th>
										                <th>Category</th>
										                <th>Product Name</th>
										                <th>Product Type</th>
										                <th>Total Orders</th>
										                <th>Total Amount</th>
										            </tr>
										        </thead>
										        <tbody>
										            <tr>
										            	<td colspan="9">No Record Found</td>
										            </tr>
										        </tbody>
										    </table>
										</div>
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
	<?php $this->load->view('include/footer.php'); ?>
	<!-- <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            var url = "<?php echo site_url() ?>product/Product/ajax";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url
            } );
        } );
    </script> -->
</div>
</body>
</html>