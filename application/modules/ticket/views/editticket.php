<?php $this->load->view('include/header.php'); ?>
<style type="text/css">
	
.form-group  .btn-group button {
    background: none;
    border: 1px solid #ccc;
    display: block;
    margin-left: 0px;
    box-shadow: none;
    width: 100%;
    border-radius: 0px; 
}
.multiselect-container>li>a>label {
    line-height: 20px;
}
.form-group .btn-group button:hover {
	background: none;
}
.btn-group.open .dropdown-toggle {
	box-shadow: none;
}
.open>.dropdown-toggle.btn-default {
	background: none !important;
	 border: 1px solid #ccc !important;
	
}
.input-group .btn-group {
    display: block;
}

span.multiselect-selected-text {
    float: left;
}

.dropdown-menu>.active>a{
background: none;
}
b.caret {
    position: absolute;
    right: 8px;
    top: 50%;
}

ul.multiselect-container.dropdown-menu {
    width: 100%;
    height: 250px;
    left: 0;
    margin-top: 33px;
    /*box-shadow: none;*/
       overflow-y: auto;
}
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
										<h3>Edit Ticket</h3>
					<div id="errorMsg" class="alert alert-danger hide">
                                          <strong>Warning!</strong>
                                        </div>
                                        <div id="successMsg" class="alert alert-success hide">
                                          <strong>Success!</strong>
                                        </div>
                                        <?php //echo "<pre>"; print_r($ticket);  ?>
                                         <?php //echo "<pre>"; print_r($user); exit; ?>
										<!-- <form class="addForm"> -->
											<?php echo form_open('',array('class'=>'addForm','id'=>'edit_ticket','enctype'=>'multipart/form-data','autocomplete'=>'off')); ?>
											<div class="row">
												<input type="hidden" name="id" id="tic_id" value="<?php echo $ticket['tic_id']; ?>">
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Title</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input  name="tic_title" id="tic_title" class="form-control" placeholder="Ticket Title"  value="<?php echo $ticket['tic_title']; ?>" type="text"></div>
														<span id="tic_title_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket User</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control selectpicker" name="tic_users[]" id="tic_user" multiple>
															 
															
														<?php if (isset($user)) {
															foreach ($user as $value) { 
																$buss = $this->generalmodel->getparticularData("business_name",'business',"business_id=".$value['user_id'],"row_array");
																if($value['urole_id']==1){
																	$st = "(ETA Global)";
																}else{
																	$st = "(LC Consultants)";
																}
																?>

															 <option value="<?php echo $value['user_id']; ?>" <?php if(in_array($value['user_id'],explode(',',$ticket['tic_users']))){echo "selected";} ?>><?php echo $value['firstname'].' '.$value['lastname'].' ('.$buss['business_name'].') '.$st; ?>
															 	
															 </option>
														<?php 	}
														} ?>
															 
															</select>
														</div>
														<span id="tic_users_err" class="invalidText"></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Category</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="tic_cat_id" id="tic_cat_id">
																<option value="">Please Select</option>
																<?php if (isset($category)) {
																	foreach ($category as $value) { ?>
																	 <option value="<?php echo $value['tic_cat_id']; ?>" <?php if($value['tic_cat_id']==$ticket['tic_cat_id']){echo "selected";} ?>><?php echo $value['tic_cat_name']; ?>
																	 	
																	 </option>
																<?php 	}
																} ?>
															 
															  <!-- <option value="">Category</option> -->
															</select>
														</div>
														<span id="tic_cat_id_err" class="invalidText"></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Ticket Status</label>
														<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
															<select class="form-control js-example-basic-single" name="tic_status" id="tic_status">
																<option value="">Please Select</option>
																<option value="0" <?php if($ticket['tic_status']==0){echo 'selected';} ?>>Open</option>
																<option value="1" <?php if($ticket['tic_status']==1){echo 'selected';} ?>>Pending</option>
																<option value="2" <?php if($ticket['tic_status']==2){echo 'selected';} ?>>Resolved</option>
																<option value="3" <?php if($ticket['tic_status']==3){echo 'selected';} ?>>Spam</option>
															
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
														<textarea cols="5" rows="5" class="desript" name="tic_desc"><?php echo $ticket['tic_desc']; ?></textarea>
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
														<form>
															<label>Filter by Type</label>
															<select id="type">
																<option value="">Please Select</option>
																<option value="All">All</option>
																<option value="Whispers">Whisper</option>
																<option value="Comment">Comment</option>
															</select>
															<button id="filter" type="button">Filter</button>
															<button  type="reset">Reset</button>

														</form>
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
	<?php $this->load->view('include/footer.php'); ?>
 <?php $this->load->view('include/readmore_modal.php'); ?>
<script>
function loadTableData(){
  			var tic_id = $('#tic_id').val();
            //var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
            var url = site_url+"ticket/Ticket/viewnote/"+tic_id;
            $('#example').dataTable( {
                "serverSide": true,
                "searching": false,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "ajax": {
			        "url": url,
			        "type": "POST",
			        "data":{'tic_id':tic_id},
			      },
			      "aaSorting": [[0, 'desc']],
            } );
        };
	loadTableData();

function loadData(){
  			var tic_id = $('#tic_id').val();
            //var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
            var url = site_url+"ticket/Ticket/viewnote/"+tic_id;
            $('#example').dataTable( {
            	"destroy": true,
                "serverSide": true,
                "searching": false,
                "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
                "ajax": {
			        "url": url,
			        "type": "POST",
			        "data":{'tic_id':tic_id},
			      },
			      "aaSorting": [[0, 'desc']],
            } );
        };	

$(document).on('click','#filter',function(){
  $('#example').DataTable().destroy();
  var type = $('#type').val();
  var tic_id = $('#tic_id').val();
  //var url = "<?php echo site_url() ?>ticket/Ticket/viewnote";
  var url = site_url+"ticket/Ticket/viewnote/"+tic_id;

   $('#example').dataTable({
      "serverSide": true,
      "responsive": true,
      "searching": false,
      "lengthMenu": [ 10, 20, 50, 100, 200,250,500 ],
      "ajax": {
        "url": url,
        "type": "POST",
        "data":{'type':type, 'tic_id':tic_id},
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
				<input type="hidden" name="id" value="<?php echo $ticket['tic_id']; ?>"> 
				<div class="form-group">
					<label>Title</label>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input  name="tic_activity_title" id="tic_activity_title" class="form-control" placeholder="Title"  value="" type="text">
						<span id="tic_activity_title_err" class="invalidText"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Type</label>
					<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
						<select class="form-control js-example-basic-single" name="tic_activity_type" id="tic_activity_type">
							<option value="">Please Select</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script>
      $(document).ready(function() {
        $('#tic_user').multiselect({
          includeSelectAllOption: true,
        });
    });
</script>
</body>
</html>