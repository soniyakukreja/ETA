<?php $this->load->view('include/header.php'); ?>
<style>
	
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
                        	<?php $this->load->view('include/leftsidebar'); ?>
								<div class="filterBody">
									<div class="filterDiv">
										<h3><?php echo $page_heading; ?></h3>
										<div class="filterTable exportButton expBtn">
											<a href="<?php echo site_url() ?>/staff/addnew" class="addNew n-m-70">Add New</a>
										<form action="<?php echo site_url() ?>staff/exportbde" method="POST">
												<input type="hidden" name="search" id="searchfltr">
											<button class="addNew">Export</button>
										</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										               <th>ID</th>
 														<th>Profile Picture</th>
										                <th>Name</th>
										                <th>Email Address</th>
										                <th>Department</th>
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
 <?php $this->load->view('include/confim_popup.php'); ?>

	<script type="text/javascript" charset="utf-8">
        function loadTableData() {
            var url = "<?php echo site_url();?>staff/Staff/ajaxbdestaff";
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