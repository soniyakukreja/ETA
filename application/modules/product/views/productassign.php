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
											<h3>Assigned Products</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										
										<div class="filterTable exportButton">
											<!-- <a href="<?php echo site_url() ?>product/updateproduct" class="addNew n-m-70">Update</a> -->
											
											<?php echo form_open('product/updateproduct',array('class'=>'addForm','id'=>'updateproduct','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
												<input type="hidden" name="lic_id" value="<?php echo $lic_id; ?>">
											<input type="submit" name="update" value="Update" class="addNew n-m-70">
											<button class="addNew">Export</button>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										            	<th class="no-sort1"><input  type="checkbox" id="selectall" /></th>
										                <th>Product Name</th>
										                <th>Product SKU</th>
										                <th>Product Type</th>
										                <th>Category</th>
										                <th>Supplier</th>
										                <th>Wholesale Price</th>
										                <th>Consumer Price</th>
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
											<?php echo form_close(); ?>
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
            var url = "<?php echo site_url() ?>product/Product/assignprodlic/<?php echo $lic_id ?>";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "aoColumnDefs": [
								  { "bSortable": false, "aTargets": [ 0 ] }
								],
            } );
        };
loadTableData();
    </script>

<script type="text/javascript" >

	$(document).on('change','#selectall',function(){
		if($(this).prop('checked')==true){
			$('.case').prop('checked',true);
		}else{
			$('.case').prop('checked',false);
		}
	});
	
</script>
</div>
</body>
</html>