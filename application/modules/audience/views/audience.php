<?php $this->load->view('include/header.php'); $this->userdata = $this->session->userdata('userdata');
	$arr=array(); $arr=$this->session->userdata('userdata');
    $perms=explode(",",$arr['upermission']);?>

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
										<a href="<?php echo site_url('audience/uploadcsv') ?>" class="addNew n-m-70 ">Import CSV</a>
										<h3>Audience</h3>
								
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<div class="filterTable exportButton expBtn <?php if(!in_array("AUD_A",$perms)){ echo 'proTable'; } ?>">
											<?php if(in_array('AUD_A',$perms)) {?><a href="<?php echo site_url() ?>audience/addaudience" class="addNew n-m-70">Add New</a><?php }?>
											<!-- <a href="<?php echo site_url() ?>audience/export" style='margin-right: -73px;' class="addNew n-m-70">Export</a>  -->
											<form action="<?php echo site_url() ?>audience/export" method="POST">
												<input type="hidden" name="search" id="searchfltr">
												<button class="addNew">Export</button>
											</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Name</th>
										                <th>Email</th>
										                <th>Business Name</th>
										                <!-- <th>User </th> -->
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
	    <?php $this->load->view('include/confim_popup.php'); ?>

	<script type="text/javascript" charset="utf-8">
        function loadTableData() {
            var url = "<?php echo site_url() ?>audience/ajax";
            // alert(url); 
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