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
								
                        			<?php $this->load->view('include/leftsidebar'); ?>
                        		
								<div class="filterBody">
									<div class="filterDiv">
											
										<h3>KAMs And CSRs</h3>
										<div id="errorMsg" class="alert alert-danger hide"></div>
										<div id="successMsg" class="alert alert-success hide"></div>

										<div class="filterTable exportButton expBtn">
											<form action="<?php echo site_url() ?>kams/remove" method="POST" id="remove">
												<input type="hidden" name="ids" id="ids">
												<button class="addNew n-m-70" type="submit" >Remove</button>
											</form>
												 <form action="<?php echo site_url() ?>kams/export" method="POST">
												<input type="hidden" name="search" id="searchfltr">
												<button class="addNew ex-btn">Export</button>
											</form>
											<table id="example" class="table table-striped table-bordered" style="width:100%">
										        <thead>
										            <tr class="n-blue-bg">
										                <th><input type="checkbox" name="chck" id="selectall"></th>
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
	 <?php $this->load->view('include/confim_popup.php'); ?>

	<script type="text/javascript" charset="utf-8">
        function loadData() {
            var url = "<?php echo site_url() ?>kams/kams/ajaxkams";
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "aoColumnDefs": [
				  { "bSortable": false, "aTargets": [ 0 ] }
				],
            } );
        };
        loadData();

        var table = $('#example').DataTable();

		$('#example').on('search.dt', function() {
		    var value = $('.dataTables_filter input').val();
		    $('#searchfltr').val(value);
		}); 

	$(document).on('change','#selectall',function(){
		if($(this).prop('checked')==true){
			$('.case').prop('checked',true);
		}else{
			$('.case').prop('checked',false);
		}
	});

$(document).on('submit','#remove',function (e) {
	e.preventDefault();
    var allIsOk = true;
	$('#errorMsg, #successMsg').addClass('hide');
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
    
    if(allIsOk){
    	ds = $(this);
		var url = $(this).attr('action');
		var formData = $("form").serialize();
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
					loadData();
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
    }
    return allIsOk    
});

    </script>
</div>
</body>
</html>