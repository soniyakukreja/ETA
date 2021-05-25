<style>
	@media (min-width: 640px){
#example_filter {
    margin: 0 100px 0 0 !important;
}
}
</style>
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
                        		<?php $this->load->view('include/leftsidebar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3>Ticket</h3>
										<div id="errorMsg" class="alert alert-danger hide"></div>
                                        <div id="successMsg" class="alert alert-success hide"></div>
										
										<div class="filterTable exportButton expBtn">
											<a href="<?php echo site_url() ?>supplier/ticket/addticket" class="addNew addBtnTablr">Add New</a>
											<?php /*
											<form action="<?php echo site_url() ?>consumer/ticket/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                         	</form>
                                         	*/ ?>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Ticket Title</th>
										                <th>Ticket Number</th>
										                <th>Made By</th>
										                <th>Status</th>
										                <th>Category</th>
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
	<?php $this->load->view('include/confim_popup'); ?>
<script>
function loadTableData(){
    var url = site_url+"supplier/ticket/ajax";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
    } );
};
	loadTableData();
	var table = $('#example').DataTable();

$('#example').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#searchfltr').val(value);
});
    </script>
</div>
</body>
</html>