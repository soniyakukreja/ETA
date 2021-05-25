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
										<h3>Pipeline Report</h3>
										<div class="filterTable exportButton expBtn proTable">
											<form action="<?php echo site_url() ?>lead/pipeline/export" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                            </form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Deal Title</th>
										                <th>Person</th>
										                <th>Business</th>
										                <th>Deal Value </th>
										                <th>Stage</th>
										                <th>Age</th>
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
	<script type="text/javascript" charset="utf-8">
   function loadData() {
            var url = "<?php echo site_url() ?>lead/pipeline/ajaxpreport";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "order": [[ 2, "desc" ]],
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
            } );
        };
        loadData(); 
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