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
										<h3>Whistle Report</h3>
										<div id="errorMsg" class="alert alert-danger hide">
										  <strong>Warning!</strong>
										</div>
										<div id="successMsg" class="alert alert-success hide">
										  <strong>Success!</strong>
										</div>
										
										<div class="filterTable exportButton expBtn proTable">
											
											<form action="<?php echo site_url() ?>complianeticket/whistleblower/exportlic" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew" >Export</button>
                                         	</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										               	<th>Licensee Name</th>
										               	<th>Business Name</th>
										                <th>Status</th>
										                <th>Amount</th>
										            </tr>
										        </thead>
										        <tbody>
										           <tr>
                                                    <td>loading...</td>
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
            var url = "<?php echo site_url() ?>complianeticket/whistleblower/ajaxlic";
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
    // console.log(value); // <-- the value
});



    </script>
</div>
</body>
</html>