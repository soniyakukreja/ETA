<?php $this->load->view('include/header.php'); 
$this->userdata = $this->session->userdata('userdata');
$perms=explode(",",$this->userdata['upermission']); ?>
<style>
	@media (max-width:767px){
.addNew {
     position: unset; 
}

.expBtn div#example_filter {
    margin-right: 0px;
}
}
</style>
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
											<?php if(in_array("PROD_D",$perms)) {?>
											<form action="<?php echo site_url() ?>product/removeassign" method="POST" id="remove">
												<input type="hidden" name="ids" id="ids">
												<button class="addNew" type="button" id="submit">Remove</button>
											</form>
										<?php } ?>
										<h3>Product</h3>

										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										
										<div class="filterTable exportButton expBtn  <?php if(!in_array("PROD_A",$perms)){ echo 'proTable'; }  ?>  ">
											<?php if(in_array("PROD_A",$perms)) {?>
											<a href="<?php echo site_url() ?>product/product/addproduct" class="addNew n-m-70">Add New</a>
											<?php }?>
											<form action="<?php echo site_url() ?>product/export" method="POST">
												<input type="hidden" name="search" id="searchfltr">
											<button class="addNew ex-btn">Export</button>
											</form>
											<div class="table-responsive">
												<table id="example" class="table table-striped table-bordered" style="width:90%">
											        <thead>
											            <tr class="n-blue-bg">
											            	<?php if(in_array('PROD_D',$perms)){ ?>
											            	<th><input type="checkbox" name="chck" id="selectall"></th> 
															<?php } ?>
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
											</div>
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
            var url = "<?php echo site_url() ?>product/Product/ajax";
            // alert(url); 
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "aoColumnDefs": [
				  { "bSortable": false, "aTargets": [ 0 ] }
				],
            } );
        };
loadTableData();

var table = $('#example').DataTable();

$('#example').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#searchfltr').val(value);
    // console.log(value); // <-- the value
}); 

$(document).on('change','#selectall',function(){
		if($(this).prop('checked')==true){
			$('.case').prop('checked',true);
		}else{
			$('.case').prop('checked',false);
		}
	});

$(document).on('click','#submit',function(){
	 var cs = [];
    var checkboxV = $("input[name='id[]']:checked");
    checkboxV.each(function()
      {cs.push($(this).val());
      });
    if(cs.length=='0')
      {
        $('#errorMsg').addClass('show').removeClass('hide').html('Please Select minimum one record');
        allIsOk = false;
        return false;
      }

     $('#ids').val(cs); 
	$('#confirm_modal').modal('show');

});

$(document).on('click','#cancel_remove',function(){
$('#confirm_modal').modal('hide');

});


$(document).on('click','#yes_removeall',function(){
	
		var url = $('#remove').attr('action');
		var formData = $("#remove").serialize();
		$.ajax({
			url: url,
			type: "POST",
			data:formData,
    		dataType: "json",
			beforeSend:function(){
				ajaxindicatorstart();
			},
			success: function(res) {
				ajaxindicatorstop();
				if(res.success) {
					$('#remove')[0].reset();
					$('#example').DataTable().destroy();

					loadTableData();
					$('#confirm_modal').modal('hide');
					$('#errorMsg').addClass('hide').removeClass('show');
					$('#successMsg').addClass('show').removeClass('hide').html(res.msg);
					
					setTimeout( function(){ 
						$('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
					 }  , 3000 );						
				}else{
					$('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
					$('#successMsg').addClass('hide').removeClass('show');
					allIsOk = false;
				}
				$('html, body').animate({
				    scrollTop: $(".dashBody").offset().top
				}, 1000); 
			}
		});

});

    </script>
</div>
</body>
</html>