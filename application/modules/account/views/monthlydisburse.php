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
								
								<?php $this->load->view('include/leftsidebar.php'); ?>
								
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Monthly Summary:</h3>
										<div class="filterTable exportButton">
											<button class="addNew">Export</button><br><br>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Date</th>
										                <th>Total Order</th>
										                <th>Total Amount</th>
										                <th>Total to Disburse </th>
										                <th>Status</th>
										                <th>Actions</th>
										            </tr>
										        </thead>
										        <tbody>
										            <tr>
										            	<td colspan="6">No Record Found</td>
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
                "ajax" : url,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
            } );
        } );
    </script> -->
</div>
</body>
</html>