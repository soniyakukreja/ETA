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
								<?php $this->load->view('include/leftsidebar.php'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Form Template Manager</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										
										<div class="filterTable expBtn exportButton">
											<a href="<?php echo site_url('product/formtemplate/addnew') ?>" class="addNew n-m-70">Add New</a>
											<form action="<?php echo site_url() ?>product/formtemplate/export" method="POST">
												<input type="hidden" name="search" id="searchfltr">
											<button class="addNew ex-btn">Export</button>
											</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Template Name</th>
										                <th>Create Date</th>
										                <th>Status</th>
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
	<?php $this->load->view('include/confim_popup.php'); ?>

<script>
   
function loadTableData(){
    var url = "<?php echo site_url('product/formtemplate/ajax') ?>";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url
    });
};
loadTableData();
    </script>
</div>
</body>
</html>