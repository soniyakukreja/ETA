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
										

										<div class="row">
		
       <div class="col-md-12 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>Business Review  <a href="<?php echo site_url() ?>business_review/editlicbusiness/<?php echo $lic['busrev_id']; ?>" style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
<a href="javascript:window.history.go(-1);" style="float: right; margin-right: 35px;">Back</a>
  </h4> </div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                    
            <div class="col-sm-9">
         
<div class="col-sm-5 col-xs-6 tital ">Title:</div><div class="col-sm-7"><?php echo $lic['busrev_title']; ?></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Due Date:</div><div class="col-sm-7"> 
	<?php 
	$localtimzone =$this->userdata['timezone'];
     $busrev_duedate = gmdate_to_mydate($lic['busrev_duedate'],$localtimzone);
            
	echo date('m-d-Y',strtotime($busrev_duedate)); 
	?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Download Template:</div><div class="col-sm-7"> <a href="<?php echo base_url('uploads/doc_template/').$doc['doc']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Business Review File:</div><div class="col-sm-7"> <?php if($lic['busrev_file']){ ?><a href="<?php echo base_url('uploads/lic_business/').$lic['busrev_file']; ?>" class="downldBtn" target="_blank" download="">Download <span class="glyphicon glyphicon-download-alt"></span></a><?php } ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Type:</div><div class="col-sm-7"> <?php echo $lic['busrev_type']; ?></div>
  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital ">Status:</div><div class="col-sm-7"><?php echo $lic['busrev_status']; ?></div>
<div class="clearfix"></div>
<div class="bot-border"></div>

<?php if($lic['busrev_status']=="Completed"){ ?>
	<div class="col-sm-5 col-xs-6 tital ">Date Completed:</div><div class="col-sm-7"> 
		<?php 
		$localtimzone =$this->userdata['timezone'];
     	$busrev_complete = gmdate_to_mydate($lic['busrev_complete'],$localtimzone);
            
		echo date('m-d-Y',strtotime($busrev_complete)); 
		// echo date('m-d-Y',strtotime($lic['busrev_complete'])); 
		?></div>
<?php } ?>

          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>  
</div>



									
									</div>


									<div class="noteDetail">
											<div class="panel panel-default">
												<div class="panel-heading"><span>Activity</span> <a href="#addNote" class="addNew" data-toggle="modal">Add Note</a></div>
												<div class="panel-body">
													<div class="detailTebler filterTable table-responsive">
														<table id="example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>User</th>
																	<th>Name</th>
																	<th>Description</th>
																	<th>Date</th>
																</tr>
															</thead>
															<tbody>
																
																<tr>
																	<td>Loading..</td>
																</tr>
															
															</tbody>
														</table>
													</div>
												</div>
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
<?php $this->load->view('include/readmore_modal.php'); ?>
<script type="text/javascript">
	function loadTableData(){
            var url = "<?php echo site_url() ?>business_review/viewnotelic";
          
            $('#example').dataTable( {
                "serverSide": true,
                "ajax" : url,
                "searching": false,
            } );
        };
	loadTableData();
</script>
<div id="addNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="addNote">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Add Note</h3>
		<?php echo form_open('business_review/addnotelic',array('class'=>'addForm','id'=>'add_note','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="app_activity_title" id="app_activity_title" class="form-control" placeholder="Title"  value="" type="text">
					</div>
						<span id="app_activity_title_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="app_activity_des" id="app_activity_des"></textarea>
					</div>
					<span id="app_activity_des_err" class="invalidText"></span>
				</div>
				<div class="addButton">
					<button>Submit</button>
					<button class="cenle" data-dismiss="modal">Cancel</button>
				</div>
			<?php echo form_close(); ?>
		</div>
    </div>

  </div>
</div>
<style type="text/css">
.modal-dialog {
    width: 600px;
    margin: 138px auto;
}
</style>
</div>
</body>
</html>