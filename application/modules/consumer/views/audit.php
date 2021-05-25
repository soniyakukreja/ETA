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
                        	<?php $this->load->view('consumer/leftbar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3><?php echo $page_heading; ?></h3>
										<div class="filterTable exportButton expoTable">
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
													<th>Audit Number</th>
													<th>Business Name</th>
													<th>Status</th>
													<th>Last Updated Date</th>
													<th>View</th>
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
            var url = site_url+"consumer/ajax_audit";
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