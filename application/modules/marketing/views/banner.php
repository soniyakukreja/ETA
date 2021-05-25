<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>
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
										<h3>Banner Manager</h3><br>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        <div class="row">
                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">

											<label>Filter by Intended User</label>
											<div class="dateInput">
											<select id="usertype" name="user" class="form-control js-example-basic-single">
												 <?php $urole = $this->userdata['urole_id'];
											   if($urole == 1){?>
											  <option value="1">ETA</option>
											  <option value="2">Licensees</option>
											  <?php } 
											  	if($urole!=3){ ?>
											  <option value="3">Industry Associations</option>
											  <?php	}
											  ?>
											  <option value="4">Consumers</option>
											  <option value="5">Suppliers</option>
											</select>
										</div>
										</div>
										</div>
										</div>
										<div class="row formDate">
											
											<div class="aplyReset">
											<button class="addNew" id="filter" type="button">Apply</button>
											<button class="addNew" id="clearfilter" type="reset" style="display:none;">Reset</button>
										</div></div>

										<div class="filterTable exportButton expBtn <?php if(!in_array("BN_A",$perms)){ echo 'proTable'; } ?>">
											<?php if(in_array("BN_A",$perms)) {?>
											<a href="<?php echo site_url() ?>marketing/page-ads-form" class="addNew n-m-70">Add New</a>
											<?php }?>
											
											<form action="<?php echo site_url() ?>marketing/exportbanner" method="POST">
                                                <input type="hidden" name="search" id="searchfltr">
                                                <button class="addNew">Export</button>
                                         	</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th>Banner Name</th>
										                <th>Intended Type</th>
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
    var url = site_url+"marketing/viewbanner";
    $('#example').dataTable( {
        "serverSide": true,
        "ajax" : url,
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
    } );
};
	loadTableData();

	$('#example').on('search.dt', function() {
	    var value = $('.dataTables_filter input').val();
	    $('#searchfltr').val(value);
	});

$(document).on('click','#filter',function(){
    filterData();
    $('#clearfilter').css('display','inline-block');
 });


function filterData(){
    var user = $('#usertype :selected').val();
    $('#example').DataTable().destroy();

    var url = site_url+"marketing/filter_banner";
    $('#example').dataTable({
        "serverSide": true,
        "responsive": true,
        "order": [[0, "asc" ]],
        "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
        "ajax": {
          "url": url,
          "type": "POST",
          "data":{'user':user},
        },
    });           
}

$(document).on('click','#clearfilter',function(){
    $('#example').DataTable().destroy();
    loadTableData();
    $('#clearfilter').css('display','none');
});


    </script>
</div>
</body>
</html>