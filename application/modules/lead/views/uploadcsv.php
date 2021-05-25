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
										<h3>Import Contact & Business</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        <div class="tableData">
										<?php echo form_open('lead/business/importcsv',array('class'=>'addForm','id'=>'uploadcsv','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group required">
														<label>Upload CSV</label>
														<div class="input-group"><span class="input-group-addon">
															<i class="glyphicon glyphicon-bookmark"></i></span>
															<input  name="file" id="file" class="form-control csvfile"  type="file" accept=".csv" is_valid="1">
														</div>
														<span id="file_err" class="invalidText csverror"></span>
													</div>
												</div>
											
												
											</div>
											<div class="row">
												<button type="submit" style="margin-right: 17px;">Import</button>
												<a href="javascript:window.history.go(-1);" class="addNew">Back</a>
												<a href="<?php echo base_url() ?>/uploads/business.csv" class="addNew" style="margin-left: 17px;">Sample Download</a>
											</div>
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
            var url = "<?php echo site_url() ?>lead/Business/ajax";
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