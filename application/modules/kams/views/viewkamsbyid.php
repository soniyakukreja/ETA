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
								<?php $this->load->view('include/leftsidebarbyid.php'); ?>
								</div>
								<div class="filterBody">
									<div class="filterDiv">
											
										<h3>KAMs And CSRs</h3>
										<div class="filterTable exportButton">
											<a  href="javascript:void(0)" class="addNew n-m-70">Remove </a>
											<!-- <button class="addNew">Export</button> -->
											 <!-- <a href="<?php echo site_url() ?>kams/export" style='margin-right: -73px;' class="addNew n-m-70">Export</a> --> 
											 <form action="<?php echo site_url() ?>kams/export" method="POST">
												<input type="hidden" name="search" id="searchfltr">
												<button class="addNew">Export</button>
											</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th><input type="checkbox" name="chck" id="chkall" onclick="checkAll(this)"></th>
										                <th>ID</th>
										                <th>Profile Picture</th>
										                <th>Name</th>
										                <th>Email Address</th>
										                <th>Type</th>
										                <th>Parent Name</th>
										                <th>Parent Email</th>
										                <th>Date Assigned</th>
										                <th>Remove</th>
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
									<?php $this->load->view('include/rightsidebar');  ?>
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
            var url = "<?php echo site_url() ?>kams/Kamsbyid/ajaxkams/<?php echo $id; ?>";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
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

 //       $('#chkall').click(function() {   
	//     if(this.checked) {
	//         // Iterate each checkbox
	//         $(':checkbox').each(function() {
	//             this.checked = true;                        
	//         });
	//     } else {
	//         $(':checkbox').each(function() {
	//             this.checked = false;                       
	//         });
	//     }
	// });

	function checkAll(ele) {
	     var checkboxes = document.getElementsByTagName('input');
	     if (ele.checked) {
	         for (var i = 0; i < checkboxes.length; i++) {
	             if (checkboxes[i].type == 'checkbox') {
	                 checkboxes[i].checked = true;
	             }
	         }
	     } else {
	         for (var i = 0; i < checkboxes.length; i++) {
	             console.log(i)
	             if (checkboxes[i].type == 'checkbox') {
	                 checkboxes[i].checked = false;
	             }
	         }
	     }
	 }

    </script>
</div>
</body>
</html>