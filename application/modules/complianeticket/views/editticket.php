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
										<h3>Edit Whistle Blower</h3>
										<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
										<!-- <form class="addForm"> -->
											<?php $business= $this->generalmodel->getSingleRowById('business','business_id', $ticket['comp_tic_business_id'], $returnType = 'array'); 
												  $Country= $this->generalmodel->getSingleRowById('country','id', $ticket['comp_tic_country_id'], $returnType = 'array');
												  $category= $this->generalmodel->getSingleRowById('user_category','user_cat_id', $ticket['tic_category_id'], $returnType = 'array');
											 ?>
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_whisle','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" value="<?php echo $ticket['comp_tic_id']; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Number</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_title" id="tic_title" class="form-control" placeholder="Ticket Title"  value="<?php echo $ticket['comp_tic_num']; ?>" type="text" disabled></div>
														<span id="tic_title_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Business Name</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_users" id="tic_users" class="form-control" placeholder="Ticket Users"  value="<?php echo $business['business_name']; ?>" type="text" maxlength="70" minlength="2" disabled></div>
														<span id="tic_users_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<!--  -->
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="comp_tic_status" id="tic_status">
																<option value="">Please Select</option>
																<option value="0" <?php if($ticket['comp_tic_status']==0){echo 'selected';} ?>>Open</option>
																<option value="1" <?php if($ticket['comp_tic_status']==1){echo 'selected';} ?>>Pending</option>
																<option value="2" <?php if($ticket['comp_tic_status']==2){echo 'selected';} ?>>Resolved</option>
																<option value="3" <?php if($ticket['comp_tic_status']==3){echo 'selected';} ?>>Spam</option>
															
															</select>
														</div>
														<span id="tic_status_err" class="invalidText"></span>
													</div>
												</div>
												
											</div>
											<div class="row">
												<div class="col-md-12">
													<!-- <div class="form-group">
 													<textarea  class="form-control xs ta-xt ckeditor" name="tic_desc" id="tic_desc" placeholder="Enter Ticket Description *" ><?php echo $ticket['tic_desc']; ?></textarea>
													</div>
													<span id="content_err" class="invalidText"></span> -->
													<!-- </div> -->
													<div class="form-group">
													<label>Description</label>
													<div class="input-group">
														<span class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i>
														</span>
														<textarea cols="5" rows="5" class="desript" name="tic_desc"><?php echo $ticket['comp_tic_message']; ?></textarea>
													</div>
													</div>
												</div>
											</div>
											
											
											
											<div class="row">
												<button type="submit" style="margin-right: 17px;">Submit</button>
							
												<a href="javascript:window.history.go(-1);" class="addNew">Back</a>
											</div>
											<?php echo form_close(); ?>
										<!-- </form> -->
							
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
																	<!-- <th>Name</th> -->
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

										<div class="row">
											<div class="col-md-6">
												
											</div>
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
		<input type="hidden" id="comp_tic_id" value="<?php echo $ticket['comp_tic_id']; ?>">
	<?php $this->load->view('include/footer.php'); ?>
<?php $this->load->view('include/readmore_modal.php'); ?>
<script>
function loadTableData(){
  			var comp_tic_id = $('#comp_tic_id').val();
            var url = "<?php echo site_url() ?>complianeticket/whistleblower/viewnote";
            $('#example').dataTable( {
                "serverSide": true,
                "searching": false,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "ajax": {
			        "url": url,
			        "type": "POST",
			        "data":{'comp_tic_id':comp_tic_id},
			      }
            } );
        };
	loadTableData();

	function loadData(){
  			var comp_tic_id = $('#comp_tic_id').val();
            var url = "<?php echo site_url() ?>complianeticket/whistleblower/viewnote";
            $('#example').dataTable( {
            	"destroy": true,
                "serverSide": true,
                "searching": false,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "ajax": {
			        "url": url,
			        "type": "POST",
			        "data":{'comp_tic_id':comp_tic_id},
			      }
            } );
        };
	

$(document).on('click','#filter',function(){
  $('#example').DataTable().destroy();
  var type = $('#type').val();
  var comp_tic_id = $('#comp_tic_id').val();
  var url = "<?php echo site_url() ?>complianeticket/whistleblower/viewnote";

   $('#example').dataTable({
      "serverSide": true,
      "responsive": true,
      "searching": false,
      "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
      "ajax": {
        "url": url,
        "type": "POST",
        "data":{'type':type, 'comp_tic_id':comp_tic_id},
      }
  });   

 });
    </script>
</div>
<!-- Modal -->
<div id="addNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="addNote">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Add Note</h3>
		<?php echo form_open('ticket/addnote',array('class'=>'addForm','id'=>'add_ticnote','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
				<input type="hidden" name="comp_tic_id" value="<?php echo $ticket['comp_tic_id']; ?>"> 
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="tic_activity_title" id="tic_activity_title" class="form-control" placeholder="Title" required="true" value="" type="text">
						<span id="tic_activity_title_err" class="invalidText"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Type</label>
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control js-example-basic-single" name="tic_activity_type" id="tic_activity_type">
							<option value="">Please Select</option>
							<option value="All">All</option>
							<option value="Whispers">Whispers</option>
							<option value="Comment">Comment</option>
						</select>
					</div>
					<span id="tic_activity_type_err" class="invalidText"></span>
				</div>
				<div class="form-group">
					<label>Description</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<textarea cols="5" rows="5" class="desript" name="tic_activity_des" id="tic_activity_des"></textarea>
					</div>
					<span id="tic_activity_des_err" class="invalidText"></span>
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
</body>
</html>